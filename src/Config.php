<?php

namespace JM\PHPMutex;

/**
 * Created by PhpStorm.
 * User: Javokhir
 * Date: 05/05/2016
 * Time: 03:41 PM
 */
class Config
{
    private $dirPath;
    private $timeout;
    private $checkInterval;

    private $checkWritable = 'check.writable';

    /**
     * Config constructor.
     * @param $dirPath
     * @param int $timeout in secs
     * @param int $checkInterval in microseconds
     * @throws InvalidConfigException
     */
    public function __construct($dirPath = __DIR__, $timeout = 5, $checkInterval = 5000) {
        if(!is_dir($dirPath))
            throw new InvalidConfigException('Folder does not exists');
        if(!is_writable(dirname($dirPath.'/'.$this->checkWritable)))
            throw new InvalidConfigException('Folder is not accessible for WRITE');
        if($timeout < 0)
            throw new InvalidConfigException('Timeout cannot be negative number');
        if($checkInterval < 0)
            throw new InvalidConfigException('Interval cannot be negative number');
        $this->dirPath = $dirPath;
        $this->timeout = $timeout;
        $this->$checkInterval = $checkInterval;
    }

    /**
     * @return string
     */
    public function getDirPath()
    {
        return $this->dirPath;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @return int
     */
    public function getCheckInterval()
    {
        return $this->checkInterval;
    }




}