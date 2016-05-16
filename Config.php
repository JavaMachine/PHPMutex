<?php

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

    private $checkWritable = 'check.writable';
    /**
     * Config constructor.
     * @param $dirPath
     * @param int $timeout
     * @throws InvalidConfigException
     */
    public function __construct($dirPath, $timeout = 10) {
        if(!is_dir($dirPath))
            throw new InvalidConfigException('Folder does not exists');
        if(!is_writable(dirname($dirPath.'/'.$this->checkWritable)))
            throw new InvalidConfigException('Folder is not accessible for WRITE');
        if($timeout < 0)
            throw new InvalidConfigException('Timeout cannot be negative number');
        $this->dirPath = $dirPath;
        $this->timeout = $timeout;
    }

    /**
     * @return mixed
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


}