<?php namespace Infrastructure\App\EventStore\PDO;

use App\EventStore\Stream;
use App\EventStore\EventBuilder;

class Stream implements Stream
{
    protected $limit = 100;
    protected $chunk_size = 100;
    
    protected $event_builder;
    
    protected $log_table = 'event_log';
    protected $streamed_count;

    protected $events;
    
    public function __construct(EventBuilder $event_builder)
    {
        $this->event_builder = $event_builder;
        
        $this->reset();
        $this->fetch();
    }
    protected function reset()
    {
        $this->streamed_count = 0;
        $this->events = [];
    }

    protected function fetch()
    {
        $this->event_snapshots = new Collection();
        $event_rows = $this->get_next_chunk();
        
        foreach ($event_rows as $event_row) {
            $this->event_builder->set_id($event_row->event_id)
                    ->set_schema_id($event_row->schema_id)
                    ->set_schema_aggregate_id($event_row->schema_aggregate_id)
                    ->set_domain_aggregate_id($event_row->domain_aggregate_id)
                    ->set_domain_payload(json_decode($event_row->payload));
            $this->events[] = $this->event_builder->build();
        }
        $this->set_offset($event_snapshot_schemas);
    }
    
    protected function 
    
    abstract protected function get_next_chunk();
    
    abstract protected function set_offset(array $event_snapshot_rows);
    protected function is_unlimited()
    {
        return ($this->limit->equals(new Integer_(0)));
    }
    protected function has_more_chunks()
    {
        return (
            $this->event_snapshots->count()->value() <
            $this->chunk_size->value()
        );
    }
    public function current()
    {
        return $this->event_snapshots->current();
    }
    public function next()
    {
        $this->event_snapshots->next();
        if(
            !$this->event_snapshots->valid() &&
            $this->has_more_chunks()
        )
        {
            $this->fetch();
        }
        $this->streamed_count = $this->streamed_count->increment();
    }
    public function key()
    {
        return $this->event_snapshots->key();
    }
    public function valid()
    {
        if(
            $this->streamed_count->equals($this->limit) &&
            !$this->is_unlimited()
        )
        {
            return false;
        }
        return $this->event_snapshots->valid();
    }
    public function rewind()
    {
        $this->event_snapshots->rewind();
    }
}