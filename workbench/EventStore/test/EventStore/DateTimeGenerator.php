<?php namespace Test\EventStore;

class DateTimeGenerator implements \App\EventStore\DateTimeGenerator
{
    public function generate()
    {
        return "2014-10-10 12:12:12";
    }
}