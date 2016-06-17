<?php namespace App\CommandStore;

abstract class AbstractCommandStream implements \Iterator
{
    protected $repo;
    
    private $chunk_size = 100;
    private $streamed_count = 0;
        
    private $commands;
       
    public function __construct(CommandRepository $repo)
    {
        $this->repo = $repo;
        
        $this->reset();
        $this->fetch();
    }
    
    protected function reset()
    {
        $this->streamed_count = 0;
        $this->commands = [];
    }

    protected function fetch()
    {
        $this->commands = $this->get_next_chunk($this->streamed_count, $this->chunk_size);
    }
        
    abstract protected function get_next_chunk($offset, $limit);
    
    protected function has_more_chunks()
    {
        return (count($this->commands) == $this->chunk_size);
    }
    
    public function current()
    {
        return current($this->commands);
    }
    
    public function next()
    {
        $command = next($this->commands);
        $this->streamed_count++;
        if(! $command && $this->has_more_chunks()) {
            $this->fetch();
        }
        
        return $command;
    }
    
    public function key()
    {
        return key($this->commands);
    }
    
    public function valid()
    {
        return current($this->commands) !== false;
    }
    
    public function rewind()
    {
     
    }
}