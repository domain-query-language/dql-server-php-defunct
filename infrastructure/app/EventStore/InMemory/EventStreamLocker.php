<?php namespace Infrastructure\App\EventStore\InMemory;

use App\EventStore\StreamID;

class EventStreamLocker implements \App\EventStore\EventStreamLocker
{
    private static $locks = [];
    
    public function lock(StreamID $stream_id)
    {
        $key = $stream_id->domain_id.",".$stream_id->schema_id;
        
        if (isset(self::$locks[$key])) {
            throw new \App\EventStore\EventStreamLockerException();
        }
        self::$locks[$key] = true;
    }
    
    public function unlock(StreamID $stream_id)
    {
        $key = $stream_id->domain_id.",".$stream_id->schema_id;
        self::$locks[$key] = null;
    }
}