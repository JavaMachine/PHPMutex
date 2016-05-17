<?php
use JM\PHPMutex\CancelException;
use JM\PHPMutex\Config;
use JM\PHPMutex\InvalidConfigException;
use JM\PHPMutex\PHPMutex;
use JM\PHPMutex\TimeOutException;

/**
 * Created by PhpStorm.
 * User: Javokhir
 * Date: 16/05/2016
 * Time: 08:28 PM
 */
class AcquireReleaseLockTest extends PHPUnit_Framework_TestCase
{
    public function testCreateConfig() {
        $isCreated = false;

        try {
            new Config(__DIR__);
            $isCreated = true;
        } catch (InvalidConfigException $e) {
            var_dump($e->getMessage());
        }
        var_dump("Config create Test: ".$isCreated);
        $this->assertTrue($isCreated, 'Config create Test');
    }

    public function testCreateLock() {
        $config = new Config(__DIR__);
        $phpMutex = new PHPMutex($config, 'testCreateLock');

        $phpMutex->acquireLockOrCancel();
        $phpMutex->releaseLock();

        var_dump("Lock file create Test: ".is_file($config->getDirPath().'/testCreateLock.lock'));
        $this->assertFileExists($config->getDirPath().'/testCreateLock.lock', 'Lock file create Test');
    }

    public function testAcquireLock() {
        $config = new Config(__DIR__);
        $phpMutex = new PHPMutex($config, 'testAcquireLock');

        $isAcquired = false;
        try {
            $phpMutex->acquireLockOrCancel();
            $isAcquired = true;
        } catch (CancelException $e) {
            var_dump($e->getMessage());
        } finally {
            $phpMutex->releaseLock();
        }
        var_dump("Lock acquire Test: ".$isAcquired);
        $this->assertTrue($isAcquired, 'Lock acquire Test');
    }

    public function testAcquiredLock() {
        $config = new Config(__DIR__);
        $phpMutex = new PHPMutex($config, 'testAcquiredLock');

        $isLocked = false;
        try {
            $phpMutex->acquireLockOrCancel();
            try {
                $phpMutex2 = new PHPMutex($config, 'testAcquiredLock');
                $phpMutex2->acquireLockOrCancel();
            } catch (CancelException $ex) {
                $isLocked = true;
                var_dump($ex->getMessage());
            }
        } catch (CancelException $e) {
            var_dump($e->getMessage());
        } finally {
            $phpMutex->releaseLock();
        }
        var_dump("Lock acquired Test: ".$isLocked);
        $this->assertTrue($isLocked, 'Lock acquired Test');
    }

    public function testAcquiredLockWait() {
        $config = new Config(__DIR__);
        $phpMutex = new PHPMutex($config, 'testAcquiredLockWait');

        $isWaited = false;
        try {
            $phpMutex->acquireLockOrCancel();
            try {
                $phpMutex2 = new PHPMutex($config, 'testAcquiredLockWait');
                $phpMutex2->acquireLockOrWait();
            } catch (TimeOutException $ex) {
                $isWaited = true;
                var_dump($ex->getMessage());
            }
        } catch (CancelException $e) {
            var_dump($e->getMessage());
        } finally {
            $phpMutex->releaseLock();
        }
        var_dump("Lock acquired WAIT Test: ".$isWaited);
        $this->assertTrue($isWaited, 'Lock acquired WAIT Test');
    }
}
