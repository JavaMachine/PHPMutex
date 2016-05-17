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
            $isCreated = false;
        } catch (InvalidConfigException $e) {

        }

        $this->assertFileExists($isCreated, 'Config create Test');
    }

    public function testCreateLock() {
        $config = new Config(__DIR__);
        $phpMutex = new PHPMutex($config, 'test');

        $phpMutex->acquireLockOrCancel();
        $phpMutex->releaseLock();

        $this->assertTrue($config->getDirPath().'/test.lock', 'Lock file create Test');
    }

    public function testAcquireLock() {
        $config = new Config(__DIR__);
        $phpMutex = new PHPMutex($config, 'test');

        $isAcquired = false;
        try {
            $phpMutex->acquireLockOrCancel();
            $isAcquired = true;
        } catch (CancelException $e) {

        } finally {
            $phpMutex->releaseLock();
        }
        $this->assertTrue($isAcquired, 'Lock acquire Test');
    }

    public function testAcquiredLock() {
        $config = new Config(__DIR__);
        $phpMutex = new PHPMutex($config, 'test');

        $isLocked = false;
        try {
            $phpMutex->acquireLockOrCancel();
            try {
                $phpMutex2 = new PHPMutex($config, 'test');
                $phpMutex2->acquireLockOrCancel();
            } catch (CancelException $ex) {
                $isLocked = true;
            }
        } catch (CancelException $e) {

        } finally {
            $phpMutex->releaseLock();
        }
        $this->assertTrue($isLocked, 'Lock acquired Test');
    }

    public function testAcquiredLockWait() {
        $config = new Config(__DIR__);
        $phpMutex = new PHPMutex($config, 'test');

        $isWaited = false;
        try {
            $phpMutex->acquireLockOrCancel();
            try {
                $phpMutex2 = new PHPMutex($config, 'test');
                $phpMutex2->acquireLockOrWait();
            } catch (TimeOutException $ex) {
                $isWaited = true;
            }
        } catch (CancelException $e) {

        } finally {
            $phpMutex->releaseLock();
        }
        $this->assertTrue($isWaited, 'Lock acquired WAIT Test');
    }
}
