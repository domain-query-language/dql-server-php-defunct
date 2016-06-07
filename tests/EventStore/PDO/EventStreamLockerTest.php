<?php namespace Test\EventStore\PDO;

use Test\EventStore\AbstractEventStreamLockerTest;
use Infrastructure\App\EventStore\PDO\EventStreamLocker;
use App\EventStore\DateTimeGenerator;

class EventStreamLockerTest extends AbstractEventStreamLockerTest
{    
    protected function make_locker(DateTimeGenerator $stub_datetime_generator)
    {
        $this->artisan('migrate');
        return new EventStreamLocker(self::$pdo, $stub_datetime_generator);
    }
}