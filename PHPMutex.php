<?php

/**
 * Created by PhpStorm.
 * User: Javokhir
 * Date: 05/05/2016
 * Time: 03:40 PM
 */
class PHPMutex
{

    private $config;
    private $name;

    /**
     * PHPMutex constructor.
     * @param Config $config
     * @param $name
     */
    public function __construct(\Config $config, $name)
    {
        $this->config = $config;
        $this->name = $name;
    }

    public function setLockOrWait()
    {

        throw new TimeOutException('Failed to acquire lock, Lock wait time out');
    }

    public function setLockOrCancel()
    {

        throw new CancelException('Failed to acquire lock');
    }

    public function releaseLock()
    {

    }
}