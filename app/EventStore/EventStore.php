<?php namespace App\EventStore;

interface EventStore
{
    public function store(array $events);
    
    /**
     * @param type $aggregate_type_id
     * @param type $aggregate_id
     * @return EventStream
     */
    public function fetch($aggregate_type_id, $aggregate_id);
}
