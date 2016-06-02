<?php namespace App\EventStore;

interface EventRepository
{
    public function fetch(StreamID $aggregate_id, $offset, $limit);
    
    public function store(array $events);
}
