<?php namespace Test\EventStore;

class DateTimeGeneratorTest extends \Test\TestCase
{    
    public function test_generates_uuid()
    {
        $datetime = (new \App\EventStore\DateTimeGenerator())->generate();
        $this->assertTrue(strtotime($datetime) !== false);
    }
}