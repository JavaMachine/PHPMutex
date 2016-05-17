# PHPMutex

[![Build Status](https://travis-ci.org/JavaMachine/PHPMutex.svg?branch=master)](https://travis-ci.org/JavaMachine/PHPMutex)

### Requirements

  - PHP 5.5, PHP 5.6, PHP 7.0

### Installation

```php
require __DIR__.'/path/to/autoload.php';
```

### Usage

Basic Usage Example:

```php
//Please Make Sure that given directory is writable
$config = new Config(__DIR__.'/sharedLocks/');
$phpMutex = new PHPMutex($config, 'nameOfTheLock');
try {
    $phpMutex->acquireLockOrCancel();

    //RUN YOUR CODE HERE

    $phpMutex->releaseLock();
} catch (CancelException $e) {
    //THROWS EXCEPTION IF IT FAILS TO ACQUIRE LOCK
}
```

Basic Usage Example (with TIMEOUT):

```php
//Please Make Sure that given directory is writable
$config = new Config(__DIR__.'/sharedLocks/', 30); //WAITS 30 seconds
$phpMutex = new PHPMutex($config, 'nameOfTheLock');
try {
    $phpMutex->acquireLockOrWait();

    //RUN YOUR CODE HERE
    //YOUR CODE RUNS SUCCESSFULLY IF WITHIN 30 SECONDS OTHER PROCESS RELEASES LOCK

    $phpMutex->releaseLock();
} catch (TimeOutException $e) {
    //THROWS EXCEPTION IF IT FAILS TO ACQUIRE LOCK WITHIN 30 SECONDS
}
```
