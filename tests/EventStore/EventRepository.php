<?php namespace Test\EventStore;

use Infrastructure\App\EventStore\AggregateID;

class EventRepository implements \Infrastructure\App\EventStore\EventRepository
{
    private $rows = [];
    
    public function set_row_count($row_count)
    {
        if ($row_count == 0) {
            return;
        }
        $this->rows = range(0, $row_count-1);
    }
    
    public function fetch(AggregateID $aggregate_id, $offset, $limit)
    {
        return array_slice($this->rows, $offset, $limit);
    }

    public function store(array $events)
    {
        
    }
}