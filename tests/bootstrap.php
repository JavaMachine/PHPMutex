<?php
/**
 * Created by PhpStorm.
 * User: Javokhir
 * Date: 17/05/2016
 * Time: 01:42 PM
 * @param $class
 */
function loader($class)
{
    $file = $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
}
spl_autoload_register('loader');
require __DIR__.'/../src/Autoloader.php';

JM\PHPMutex\Autoloader::register();