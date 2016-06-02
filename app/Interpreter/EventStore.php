<?php namespace App\Interpreter;

interface EventStore
{
    public function fetch($domain_aggregate_id, $schema_aggregate_id);
    
    public function store(array $events);
}
