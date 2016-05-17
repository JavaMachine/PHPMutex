<?php

namespace JM\PHPMutex;



/**
 * Created by PhpStorm.
 * User: Javokhir
 * Date: 05/05/2016
 * Time: 03:40 PM
 */
class PHPMutex
{
    private $config;
    private $fileResource;

    /**
     * PHPMutex constructor.
     * @param Config $config
     * @param $name
     */
    public function __construct(Config $config, $name)
    {
        $this->config = $config;
        $this->fileResource = fopen($this->config->getDirPath().'/'.$name.'.lock', "a+");
    }

    public function acquireLockOrWait()
    {
        $endTime = microtime(true) + $this->config->getTimeout();
        while(!flock($this->fileResource, LOCK_EX | LOCK_NB)) {
            if(microtime(true) >= $endTime) {
                fclose($this->fileResource);
                throw new TimeOutException('Failed to acquire lock, Lock wait time out');
            }
            usleep($this->config->getCheckInterval());
        }
    }

    public function acquireLockOrCancel()
    {
        if (!flock($this->fileResource, LOCK_EX | LOCK_NB)) {
            fclose($this->fileResource);
            throw new CancelException('Failed to acquire lock');
        }
    }

    public function releaseLock()
    {
        flock($this->fileResource, LOCK_UN);
        fclose($this->fileResource);
    }
}