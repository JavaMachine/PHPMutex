<?php
namespace JM\PHPMutex;
use Exception;
/**
 * Created by PhpStorm.
 * User: Javokhir
 * Date: 05/05/2016
 * Time: 04:00 PM
 */
class InvalidConfigException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}