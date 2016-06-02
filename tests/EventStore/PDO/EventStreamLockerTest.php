<?php namespace Test\EventStore\PDO;

use Test\EventStore\AbstractEventStreamLockerTest;
use Infrastructure\App\EventStore\PDO\EventStreamLocker;

class EventStreamLockerTest extends AbstractEventStreamLockerTest
{    
    protected function make_locker()
    {
        $this->artisan('migrate');
        return new EventStreamLocker(self::$pdo);
    }
}