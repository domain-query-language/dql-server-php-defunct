<?php namespace Infrastructure\App\EventStore;

interface EventRepository
{
    public function fetch(AggregateID $aggregate_id, $offset, $limit);
    
    public function store(array $events);
}
