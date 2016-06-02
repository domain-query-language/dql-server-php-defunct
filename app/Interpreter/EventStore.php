<?php namespace App\Interpreter;

interface EventStore
{
    public function fetch($aggregate_id, $aggregate_type_id);
    
    public function store(array $events);
}
