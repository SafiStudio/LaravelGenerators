<?php
namespace SafiStudio;

use \Composer\Script\Event;
use \Composer\Installer\PackageEvent;

class Installer
{

    public static function postUpdate(Event $event)
    {
        $composer = $event->getComposer();
        self::createFiles();
        self::createConsoleCommand();
        self::createStatic();
    }

    public static function createConsoleCommand(){
        $generator = 'vendor/safistudio/generators/commands/Generator.php';
        $command_file = 'app/Console/Commands/Generator.php';

        if(file_exists($command_file))
            unlink($command_file);

        copy($generator, $command_file);

        echo "\nGenerator file is copied. Remeber to add \\SafiStudio\\Console\\Commands\\Generator::class into Kernel commands\n";
    }

    public static function createFiles(){
        $folders = [
            'public/css',
            'public/css/admin',
            'public/css/fontawesome',
            'public/css/fontawesome/css',
            'public/css/fontawesome/fonts',
            'public/js',
            'public/js/admin',
            'public/data',
            'public/images',
            'resources/views/layouts',
            'resources/views/admin',
            'app/Generators',
            'app/Http/Controllers/Admin',
            'app/Http/Middleware/Admin',
        ];

        $files = [
            'vendor/safistudio/generators/assets/css/admin/style.less' => 'public/css/admin/style.less',
            'vendor/safistudio/generators/assets/css/admin/style.css' => 'public/css/admin/style.css',
            'vendor/safistudio/generators/assets/css/fontawesome/css/font-awesome.css' => 'public/css/fontawesome/css/font-awesome.css',
            'vendor/safistudio/generators/assets/css/fontawesome/css/font-awesome.min.css' => 'public/css/fontawesome/css/font-awesome.min.css',
            'vendor/safistudio/generators/assets/css/fontawesome/fonts/FontAwesome.otf' => 'public/css/fontawesome/fonts/FontAwesome.otf',
            'vendor/safistudio/generators/assets/css/fontawesome/fonts/fontawesome-webfont.eot' => 'public/css/fontawesome/fonts/fontawesome-webfont.eot',
            'vendor/safistudio/generators/assets/css/fontawesome/fonts/fontawesome-webfont.svg' => 'public/css/fontawesome/fonts/fontawesome-webfont.svg',
            'vendor/safistudio/generators/assets/css/fontawesome/fonts/fontawesome-webfont.ttf' => 'public/css/fontawesome/fonts/fontawesome-webfont.ttf',
            'vendor/safistudio/generators/assets/css/fontawesome/fonts/fontawesome-webfont.woff' => 'public/css/fontawesome/fonts/fontawesome-webfont.woff',
            'vendor/safistudio/generators/assets/css/fontawesome/fonts/fontawesome-webfont.woff2' => 'public/css/fontawesome/fonts/fontawesome-webfont.woff2',
            'vendor/safistudio/generators/assets/js/admin/jquery-2.1.4.min.js' => 'public/js/admin/jquery-2.1.4.min.js',
            'vendor/safistudio/generators/assets/js/admin/scripts.js' => 'public/js/admin/scripts.js',
            'vendor/safistudio/generators/templates/layouts/admin.blade.php' => 'resources/views/layouts/admin.blade.php',
            'vendor/safistudio/generators/templates/layouts/login.blade.php' => 'resources/views/layouts/login.blade.php',
            'vendor/safistudio/generators/templates/views/admin/login.blade.php' => 'resources/views/admin/login.blade.php',
            'vendor/safistudio/generators/templates/views/admin/panel.blade.php' => 'resources/views/admin/panel.blade.php',
            'vendor/safistudio/generators/sample/Hotels.php' => 'app/Generators/Hotels.php',
        ];
        echo "\n";
        foreach($folders as $folder){
            if(!is_dir($folder)){
                mkdir($folder, 0755);
                echo 'Create '.$folder." directory\n";
            }

        }
        echo "\n";
        foreach($files as $source => $file){
            if(!file_exists($file)){
                copy($source, $file);
                echo 'Create '.$file." file\n";
            }
        }
    }

    static function createStatic(){
        $app = file_get_contents('bootstrap/app.php');
        preg_match_all('/(.*)Http(.*)/i', $app, $matches);
        $namespace = trim($matches[1][1]);

        $auth = file_get_contents('vendor/safistudio/generators/templates/controllers/AuthController.php');
        $panel = file_get_contents('vendor/safistudio/generators/templates/controllers/PanelController.php');
        $middle = file_get_contents('vendor/safistudio/generators/templates/middleware/Authenticate.php');

        $auth = str_replace('GeneratorNameSpace\\', $namespace, $auth);
        $panel = str_replace('GeneratorNameSpace\\', $namespace, $panel);
        $middle = str_replace('GeneratorNameSpace\\', $namespace, $middle);

        if(!file_exists('app/Http/Controllers/Admin/AuthController.php')){
            $file = fopen('app/Http/Controllers/Admin/AuthController.php', 'w');
            fwrite($file, $auth);
        }

        if(!file_exists('app/Http/Controllers/Admin/PanelController.php')){
            $file = fopen('app/Http/Controllers/Admin/PanelController.php', 'w');
            fwrite($file, $panel);
        }

        if(!file_exists('app/Http/Middleware/Admin/Authenticate.php')){
            $file = fopen('app/Http/Middleware/Admin/Authenticate.php', 'w');
            fwrite($file, $middle);
        }

        $add_php = false;
        $rt_file = 'app/Http/routes.php';
        if(file_exists($rt_file)){
            $rt_handle = fopen($rt_file, 'a+');
            $rt_code = "
// Admin Authentication routes...
Route::get('admin/login', 'Admin\\AuthController@getLogin');
Route::post('admin/login', 'Admin\\AuthController@postLogin');
Route::get('admin/logout', 'Admin\\AuthController@getLogout');

// --- Routing for Panel
Route::get('admin/panel', [
	'middleware' => 'auth.admin',
	'uses' => 'Admin\\PanelController@index'
]);
            ";
            fwrite($rt_handle, $rt_code);
            fclose($rt_handle);
        }


        echo "\nStatic files are copied. Remeber to add 'auth.admin' => \\".$namespace."Http\\Middleware\\Admin\\Authenticate::class into Kernel middlewares\n\n";

    }

}