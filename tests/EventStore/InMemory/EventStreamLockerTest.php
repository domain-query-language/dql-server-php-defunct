<?php namespace Test\EventStore\InMemory;

use Test\EventStore\AbstractEventStreamLockerTest;
use Infrastructure\App\EventStore\InMemory\EventStreamLocker;

class EventStreamLockerTest extends AbstractEventStreamLockerTest
{    
    protected function make_locker()
    {
        return new EventStreamLocker();
    }
}