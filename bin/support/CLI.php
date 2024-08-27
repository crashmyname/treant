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
        // Menghapus nama file dari argumen
        array_shift($argv);

        // Ambil nama perintah
        $command = array_shift($argv);
        $method = $this->commands[$command] ?? null;

        if ($method && method_exists($this, $method)) {
            call_user_func_array([$this, $method], $argv);
        } else {
            echo "Perintah tidak ditemukan!\n";
        }
    }

    protected function createModel($name)
    {
        $modelTemplate = "<?php\n\nnamespace Model;\nuse Support\BaseModel;\n\nclass $name extends BaseModel\n{\n    // Model logic here\n}\n";
        file_put_contents("Model/{$name}.php", $modelTemplate);
        echo "Model $name berhasil dibuat!\n";
    }

    protected function createController($name)
    {
        $controllerTemplate = "<?php\n\nnamespace Controller;\nuse Support\Request;\nuse Support\Validator;\nuse Support\View;\nuse Support\CSRFToken;\n\nclass {$name}\n{\n    // Controller logic here\n}\n";
        file_put_contents("Controller/{$name}.php", $controllerTemplate);
        echo "Controller {$name}Controller berhasil dibuat!\n";
    }

    // Anda bisa menambahkan metode lain untuk perintah lain di sini
}

?>