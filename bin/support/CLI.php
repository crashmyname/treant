<?php
namespace Support;

class CLI
{
    protected $commands = [
        'make:model' => 'createModel',
        'make:controller' => 'createController',
        // Tambahkan perintah lainnya di sini
    ];

    public function run($argv)
    {
        $command = $argv[1] ?? null;
        $argument = $argv[2] ?? null;

        // Cek apakah perintah dikenali
        if ($command && isset($this->commands[$command])) {
            $method = $this->commands[$command];
            $this->$method($argument);
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
        $modelTemplate = "<?php\n\nnamespace Model;\nuse Support\BaseModel;\n\nclass $name extends BaseModel\n{\n    // Model logic here\n}\n";
        $filePath = "Model/{$name}.php";
        if (file_exists($filePath)) {
            echo "Model $name sudah ada!\n";
        } else {
            file_put_contents($filePath, $modelTemplate);
            echo "Mode $name berhasil dibuat!\n";
        }
    }

    protected function createController($name)
    {
        if (!$name) {
            echo "Nama controller harus diberikan!\n";
            return;
        }
        $controllerTemplate = "<?php\n\nnamespace Controller;\nuse Support\Request;\nuse Support\Validator;\nuse Support\View;\nuse Support\CSRFToken;\n\nclass {$name}\n{\n    // Controller logic here\n}\n";
        $filePath = "Controller/{$name}.php";
        if (file_exists($filePath)) {
            echo "Controller $name sudah ada!\n";
        } else {
            file_put_contents($filePath, $controllerTemplate);
            echo "Controller {$name} berhasil dibuat!\n";
        }
    }

    // Anda bisa menambahkan metode lain untuk perintah lain di sini
}

?>