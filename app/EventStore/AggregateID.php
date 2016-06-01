<?php namespace App\EventStore;

class AggregateID
{
    public $schema_id;
    public $domain_id;
    
    public function __construct($schema_id, $domain_id)
    {
        $this->schema_id = $schema_id;
        $this->domain_id = $domain_id;
    }
}
