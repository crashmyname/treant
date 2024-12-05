<?php
namespace Support;
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/Prefix.php';

class Treant
{
    protected $commands = [
        'make:model' => 'createModel',
        'make:controller' => 'createController',
        'serve' => 'Serve',
        // Tambahkan perintah lainnya di sini
    ];

    public function run($argv)
    {
        $command = $argv[1] ?? null;
        $argument = $argv[2] ?? null;
        $options = array_slice($argv, 3);

        // Cek apakah perintah dikenali
        if ($command && isset($this->commands[$command])) {
            $method = $this->commands[$command];
            $this->$method($argument, $options);
        } else {
            echo "Perintah tidak ditemukan!\n";
        }
    }

    protected function createModel($name)
    {
        if (!$name) {
            echo "Nama model harus diberikan!\n";
            return;
        }
        $modelTemplate = "<?php\n\nnamespace App\Models;\nuse Support\BaseModel;\n\nclass $name extends BaseModel\n{\n    // Model logic here\n}\n";
        $filePath = "app/Models/{$name}.php";
        if (file_exists($filePath)) {
            echo "Model $name sudah ada!\n";
        } else {
            file_put_contents($filePath, $modelTemplate);
            echo "Model $name berhasil dibuat!\n";
        }
    }

    protected function createController($name, $options = [])
    {
        if (!$name) {
            echo "Nama controller harus diberikan!\n";
            return;
        }

        // Pisahkan namespace dan nama file
        $pathParts = explode('/', $name);
        $className = array_pop($pathParts);
        $namespace = 'App\\Controllers';
        if (!empty($pathParts)) {
            $namespace .= '\\' . implode('\\', $pathParts);
        }
        $directory = 'app/Controllers/' . implode('/', $pathParts);

        // Pastikan folder target ada
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true); // Buat folder secara rekursif
        }

        $isResource = in_array('--resource', $options);
        $controllerTemplate = "<?php\n\nnamespace {$namespace};\n\nuse Support\BaseController;\nuse Support\Request;\nuse Support\Validator;\nuse Support\View;\nuse Support\CSRFToken;\n\nclass {$className} extends BaseController\n{\n";
        if ($isResource) {
            $controllerTemplate .= "    public function index()\n    {\n        // Tampilkan semua resource\n    }\n\n";
            $controllerTemplate .= "    public function show(\$id)\n    {\n        // Tampilkan resource dengan ID: \$id\n    }\n\n";
            $controllerTemplate .= "    public function store(Request \$request)\n    {\n        // Simpan resource baru\n    }\n\n";
            $controllerTemplate .= "    public function update(Request \$request, \$id)\n    {\n        // Update resource dengan ID: \$id\n    }\n\n";
            $controllerTemplate .= "    public function destroy(\$id)\n    {\n        // Hapus resource dengan ID: \$id\n    }\n";
        } else {
            $controllerTemplate .= "    // Controller logic here\n";
        }
        $controllerTemplate .= "}\n";

        $filePath = "{$directory}/{$className}.php";

        if (file_exists($filePath)) {
            echo "Controller $name sudah ada!\n";
        } else {
            file_put_contents($filePath, $controllerTemplate);
            echo "Controller {$name} berhasil dibuat di {$filePath}!\n";
        }
    }

    protected function Serve()
    {
        $host = '127.0.0.1';
        $port = '8000';

        global $argv;
        foreach($argv as $arg){
            if(strpos($arg, '--host=') !== false){
                $host = substr($arg, 7);
            }
            if(strpos($arg, '--port=') !== false){
                $port = substr($arg, 7);
            }
        }
        if (!filter_var($host, FILTER_VALIDATE_IP)) {
            echo "Error: Invalid host address provided: $host\n";
            exit(1); // Exit with error
        }
    
        // Validate port (must be numeric and within range)
        if (!is_numeric($port) || (int)$port < 1024 || (int)$port > 65535) {
            echo "Error: Invalid port number provided: $port\n";
            exit(1); // Exit with error
        }
        
        echo "Starting development server on http://{$host}:{$port}\n";
        exec("php -S {$host}:{$port}");
    }

}

?>