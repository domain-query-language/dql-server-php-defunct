<?php namespace App\EventStore;

class FullEventStream implements \Iterator
{
    private $chunk_size = 100;
    private $streamed_count = 0;
    
    private $event_repo;
    
    private $events;
       
    public function __construct(EventRepository $event_repo)
    {
        $this->event_repo = $event_repo;
        
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
        $this->events = $this->get_next_chunk();
    }
        
    private function get_next_chunk()
    {
        $offset = $this->streamed_count;
        $limit = $this->chunk_size;
        return $this->event_repo->fetch_all($offset, $limit);
    }
    
    protected function has_more_chunks()
    {
        return (count($this->events) == $this->chunk_size);
    }
    
    public function current()
    {
        return current($this->events);
    }
    
    public function next()
    {
        $event = next($this->events);
        $this->streamed_count++;
        if(! $event && $this->has_more_chunks()) {
            $this->fetch();
        }
        
        return $event;
    }
    
    public function key()
    {
        return key($this->events);
    }
    
    public function valid()
    {
        return current($this->events) !== false;
    }
    
    public function rewind()
    {
     
    }
}