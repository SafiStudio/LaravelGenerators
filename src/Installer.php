<?php
namespace SafiStudio;

use \Composer\Script\Event;
use \Composer\Installer\PackageEvent;

class Installer
{
    use \Illuminate\Console\AppNamespaceDetectorTrait;

    public static function postUpdate(Event $event)
    {
        $composer = $event->getComposer();
        self::createConsoleCommand();
    }

    public static function postPackageInstall(PackageEvent $event)
    {
        $installedPackage = $event->getOperation()->getPackage();
    }

    public static function createConsoleCommand(){
        $generator = 'vendor/safistudio/generators/commands/Generator.php';
        $command_file = 'app/Console/Commands/Generator.php';

        if(file_exists($command_file))
            unlink($command_file);

        copy($generator, $command_file);

        echo "\nGenerator file is copied. Remeber to add \\SafiStudio\\Console\\Commands\\Generator::class into Kernel commands\n\n";
    }

    public static function warmCache(Event $event){
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
            'app/Generators',
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
            'vendor/safistudio/generators/assets/images/bg_standard.jpg' => 'public/images/bg_standard.jpg',
            'vendor/safistudio/generators/templates/layouts/admin.blade.php' => 'resources/views/layouts/admin.blade.php',
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

        self::createConsoleCommand();
    }

}