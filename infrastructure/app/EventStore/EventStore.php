<?php namespace Infrastructure\App\EventStore;

interface EventStore 
{
    public function store(array $events);
    
    public function fetch($aggregate_id, $aggregate_type_id);
}