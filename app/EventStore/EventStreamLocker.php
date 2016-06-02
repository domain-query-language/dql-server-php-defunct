<?php namespace App\EventStore;

interface EventStreamLocker
{
    public function lock(StreamID $id);
    
    public function unlock(StreamID $id);
    
}
