<?php
/**
 * Created by PhpStorm.
 * User: SafiStudio
 * Date: 05.08.15
 * Time: 11:31
 */

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
        self::createConsoleCommand();
    }

    public static function createConsoleCommand(){
        $namespace = sefl::getAppNamespace();
        $command_file = app_path().'/Console/Commands/Generator.php';

        if(file_exists($command_file))
            unlink($command_file);

        $content = file_get_contents(base_path().'/vendor/safistudio/generators/commands/Generator.php');
        $content = str_replace('AppNameSpace\\', $namespace, $content);
        $file = fopen($command_file, 'w');
        fwrite($file, $content);
        fclose();
    }
}