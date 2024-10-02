<?php
namespace Support;
require_once __DIR__ . '/Asset.php';
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
        $modelTemplate = "<?php\n\nnamespace App\Models;\nuse Support\BaseModel;\n\nclass $name extends BaseModel\n{\n    // Model logic here\n}\n";
        $filePath = "app/Model/{$name}.php";
        if (file_exists($filePath)) {
            echo "Model $name sudah ada!\n";
        } else {
            file_put_contents($filePath, $modelTemplate);
            echo "Model $name berhasil dibuat!\n";
        }
    }

    protected function createController($name)
    {
        if (!$name) {
            echo "Nama controller harus diberikan!\n";
            return;
        }
        $controllerTemplate = "<?php\n\nnamespace App\Controllers;\nuse Support\Request;\nuse Support\Validator;\nuse Support\View;\nuse Support\CSRFToken;\n\nclass {$name}\n{\n    // Controller logic here\n}\n";
        $filePath = "app/Controller/{$name}.php";
        if (file_exists($filePath)) {
            echo "Controller $name sudah ada!\n";
        } else {
            file_put_contents($filePath, $controllerTemplate);
            echo "Controller {$name} berhasil dibuat!\n";
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