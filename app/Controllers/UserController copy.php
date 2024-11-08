<?php

namespace App\Controllers;
use App\Models\User;
use Config\Database;
use PDO;
use PDOException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Support\BaseController;
use Support\Crypto;
use Support\Request;
use Support\Response;
use Support\UUID;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class UserController extends BaseController
{
    // Controller logic here

    private function appendRouteToFile($controllerName, $moduleName)
    {
        $routeFile = realpath(__DIR__ . '/../../routes/route.php'); // Pastikan path ini sesuai

        // Baca isi file yang ada
        $fileContents = file_get_contents($routeFile);

        // Pastikan file diawali dengan tag PHP
        if (strpos($fileContents, '<?php') === false) {
            // Jika tag PHP belum ada, kita tambahkan di depan
            $fileContents = "<?php\n" . $fileContents;
        }

        // Periksa apakah import controller sudah ada
        $controllerImport = "use App\Controllers\\{$controllerName};";

        // Jika import belum ada, tambahkan di bagian atas file
        if (strpos($fileContents, $controllerImport) === false) {
            // Cari posisi setelah tag PHP
            $position = strpos($fileContents, '<?php') + strlen('<?php');

            // Sisipkan import di bawah tag PHP
            $fileContents = substr($fileContents, 0, $position) . "\n" . $controllerImport . "\n" . substr($fileContents, $position);
        }

        // Pastikan `Route::dispatch();` ada di akhir, jika tidak tambahkan
        if (strpos($fileContents, 'Route::dispatch();') === false) {
            $fileContents .= "\nRoute::dispatch();";
        }
        $moduleName = strtolower($moduleName);
        // Buat string route baru
        $newRoutes = <<<EOT
            // Routes for $moduleName module
            Route::get('/$moduleName', [{$controllerName}::class, 'index'])->name('$moduleName.index');
            Route::get('/$moduleName/create', [{$controllerName}::class, 'create'])->name('$moduleName.create');
            Route::post('/$moduleName', [{$controllerName}::class, 'store'])->name('$moduleName.store');
            Route::get('/$moduleName/{id}/edit', [{$controllerName}::class, 'edit'])->name('$moduleName.edit');
            Route::put('/$moduleName/{id}', [{$controllerName}::class, 'update'])->name('$moduleName.update');
            Route::delete('/$moduleName/{id}', [{$controllerName}::class, 'destroy'])->name('$moduleName.destroy');
        EOT;

        // Tentukan posisi akhir blok PHP (di mana Route::dispatch() berada)
        $position = strpos($fileContents, 'Route::dispatch();');

        // Sisipkan route baru tepat sebelum Route::dispatch()
        $newFileContents = substr($fileContents, 0, $position) . "\n" . $newRoutes . "\n" . substr($fileContents, $position);

        // Tulis ulang isi file dengan menambahkan route baru
        file_put_contents($routeFile, $newFileContents);
    }

    private function createModel($moduleName, $columns)
    {
        $modelName = ucfirst($moduleName);
        $filePath = __DIR__ . "/../Models/{$modelName}.php";

        // Buat daftar kolom untuk `fillable`
        $fillableColumns = implode(
            ', ',
            array_map(function ($col) {
                return "'{$col['name']}'";
            }, $columns),
        );

        $modelContent = <<<EOT
        <?php

        namespace App\Models;

        use Support\Database;
        use Support\BaseModel;

        class $modelName extends BaseModel{
            public \$table = '$moduleName';
            protected \$primaryKey = 'id';
            protected \$fillable = [$fillableColumns];
        }
        EOT;

        file_put_contents($filePath, $modelContent);
        echo "Model {$modelName} created successfully.\n <br>";
    }

    private function createController($moduleName, $columns)
    {
        $controllerName = ucfirst($moduleName) . 'Controller';
        $filePath = __DIR__ . "/{$controllerName}.php";

        // Buat daftar kolom untuk `fillable`
        $fillableColumns = implode(
            ', ',
            array_map(function ($col) {
                return "'{$col['name']}'";
            }, $columns),
        );

        $controllerContent = <<<EOT
        <?php

        namespace App\Controllers;

        use App\Models\\$moduleName;
        use Support\BaseController;
        use Support\Request;
        use Support\View;
        use Support\Response;

        class $controllerName extends BaseController{

            public function index() {
                // Fetch all data
                \$data = $moduleName::all();
                return View::render('{$moduleName}/index',['data'=>\$data]);
            }

            public function create() {
                // Render create form
                return View::render('{$moduleName}/create');
            }

            public function store(Request \$request) {
                // Save new record
                \$data = \$request->only([$fillableColumns]);
                $moduleName::create(\$data);
                Response::json(['message' => '{$moduleName} created successfully']);
            }

            public function edit(\$id) {
                // Render edit form
                \$item = $moduleName::find(\$id);
                return View::render('{$moduleName}/edit', ['item' => \$item]);
            }

            public function update(Request \$request, \$id) {
                // Update record
                \$data = \$request->only([$fillableColumns]);
                \$item = $moduleName::find(\$id);
                \$item->update(\$data);
                Response::json(['message' => '{$moduleName} updated successfully']);
            }

            public function destroy(\$id) {
                // Delete record
                $moduleName::destroy(\$id);
                Response::json(['message' => '{$moduleName} deleted successfully']);
            }
        }
        EOT;

        file_put_contents($filePath, $controllerContent);
        echo "Controller {$controllerName} created successfully.\n <br>";
    }

    private function createDatabaseTable($moduleName, $columns)
    {
        $tableName = strtolower($moduleName);
        $query = "CREATE TABLE IF NOT EXISTS `{$tableName}` (id INT AUTO_INCREMENT PRIMARY KEY";

        foreach ($columns as $column) {
            $colName = '`' . $column['name'] . '`';
            $colType = $column['type'] === 'string' ? 'VARCHAR(255)' : strtoupper($column['type']);

            // Menambahkan kolom tanpa mendefinisikan PRIMARY KEY jika sudah ada ID sebagai primary key
            $query .= ", {$colName} {$colType}";

            // Jika kolom harus unik, tambahkan constraint UNIQUE
            if (!empty($column['primary']) && $column['name'] !== 'id') {
                $query .= ' UNIQUE';
            }
        }

        $query .= ');';

        // Jalankan query
        $database = new \Support\Database();
        $database->query($query);

        echo "Database table {$tableName} created successfully.\n";
    }

    private function createViews($moduleName, $columns)
    {
        $viewDir = __DIR__ . "/../../src/View/{$moduleName}";
        if (!file_exists($viewDir)) {
            mkdir($viewDir, 0777, true);
        }

        // Create index view
        $indexContent = "<h1>{$moduleName} List</h1>\n<!-- Add list display here -->";
        file_put_contents("$viewDir/index.php", $indexContent);

        // Create create view
        $createContent = "<h1>Create {$moduleName}</h1>\n<!-- Add create form here -->";
        file_put_contents("$viewDir/create.php", $createContent);

        // Create edit view
        $editContent = "<h1>Edit {$moduleName}</h1>\n<!-- Add edit form here -->";
        file_put_contents("$viewDir/edit.php", $editContent);

        echo "Views for {$moduleName} created successfully.\n <br>";
    }

    public function module()
    {
        try {
            // Cek status database
            $dbStatus = 'Connected';
            $pdo = Database::getConnection();
        } catch (PDOException $e) {
            $dbStatus = 'Database connection failed: ' . $e->getMessage();
        }
        $cpuLoad = null;
        if (stristr(PHP_OS, 'WIN')) {
            // Menggunakan perintah Windows untuk mendapatkan load CPU
            $cpuLoad = shell_exec('wmic cpu get loadpercentage');

            // Membersihkan karakter \r\n dan string yang tidak diperlukan
            $cpuLoad = trim(str_replace(["\r", "\n", 'LoadPercentage'], '', $cpuLoad));

            // Mengubah hasil menjadi integer
            $cpuLoad = (int) $cpuLoad;
        } else {
            // Menggunakan perintah Linux untuk mendapatkan load CPU
            $cpuLoad = shell_exec('uptime');

            // Membersihkan karakter \r\n dan string yang tidak diperlukan
            $cpuLoad = trim(str_replace(["\r", "\n", 'LoadPercentage'], '', $cpuLoad));

            // Mengubah hasil menjadi integer
            $cpuLoad = (int) $cpuLoad;
        }
        $memoryUsage = memory_get_usage(); // Mendapatkan penggunaan memori
        $diskUsage = memory_get_peak_usage();
        $diskTotalSpace = disk_total_space('/'); // Total ruang di drive root
        $diskFreeSpace = disk_free_space('/');   // Ruang bebas di drive root
        $diskUsedSpace = $diskTotalSpace - $diskFreeSpace; // Menghitung ruang yang digunakan
        $startTime = microtime(true);
        $executionTime = round(microtime(true) - $startTime,6);
        // Menampilkan status
        return tojson([
            'status' => 'ok',
            'database' => $dbStatus,
            'cpu_load' => $cpuLoad,
            'memory_usage' => $memoryUsage,
            'disk_usage' => $diskUsage,
            'disk_total_space' => $diskTotalSpace,
            'disk_free_space' => $diskFreeSpace,
            'disk_used_space' => $diskUsedSpace,
            'execution_time' => $executionTime
        ]);
    }

    public function monitor()
    {
        return View::render('monitor');
    }

    public function create(Request $request)
    {
        $moduleName = $request->module_name;
        $columns = $request->columns;

        $this->createController($moduleName, $columns);
        $this->createModel($moduleName, $columns);
        $this->createViews($moduleName, $columns);
        $this->createDatabaseTable($moduleName, $columns);

        // Tambahkan route ke file route
        $this->appendRouteToFile("{$moduleName}Controller", $moduleName);

        echo "CRUD module $moduleName successfully created!";
    }

    public function exportUsersToExcel()
    {
        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul kolom
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Email');

        // Mengambil data dari model
        $users = User::all();
        $row = 2;

        foreach ($users as $user) {
            $sheet->setCellValue("A{$row}", $user['user_id']);
            $sheet->setCellValue("B{$row}", $user['username']);
            $sheet->setCellValue("C{$row}", $user['email']);
            $row++;
        }

        // Tulis ke file Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'users.xlsx';
        $filePath = asset('excel/') . $fileName;

        $writer->save($filePath);

        // Kembalikan respons download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$fileName}\"");
        readfile($filePath);

        exit();
    }
    public function index()
    {
        $user = User::all();
        View::render('test', ['user' => $user]);
    }
    public function show($id)
    {
        $decID = Crypto::decrypt($id);
        $user = User::find($decID);
        if (!$user) {
            View::error('errors/404');
        }
        View::render('testi', ['user' => $user]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator) {
            // Tampilkan error validasi
            return Response::json(['status' => 'error']);
        }

        // Jika validasi berhasil, buat user baru
        User::create([
            'uuid' => UUID::generateUuid(),
            'username' => $request->username,
            'email' => $request->email,
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
        ]);
        View::redirectTo('/test');
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            View::error('errors/404');
        }

        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:users',
        ]);

        if ($validator) {
            return Response::json(['status' => 'error']);
        }

        // Jika validasi berhasil, update data user
        $user->updated([
            'username' => $request->username,
            'email' => $request->email,
        ]);
        return View::redirectTo('/test');
    }
    public function destroy($id)
    {
        $decID = Crypto::decrypt($id);
        $user = User::find($decID);
        if (!$user) {
            View::error('errors/404');
        }
        $user->delete();
        return View::redirectTo('/test');
    }
}
