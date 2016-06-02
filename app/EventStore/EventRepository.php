<?php namespace App\EventStore;

interface EventRepository
{
    public function fetch(StreamID $stream_id, $offset, $limit);
    
    public function store(array $events);
    
    public function lock(StreamID $stream_id);
    
    public function unlock(StreamID $stream_id);
}
