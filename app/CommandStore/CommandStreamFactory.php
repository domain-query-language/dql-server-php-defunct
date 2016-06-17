<?php namespace App\CommandStore;

class CommandStreamFactory
{
    private $event_repo;
    
    public function __construct(CommandRepository $event_repo)
    {
        $this->event_repo = $event_repo;
    }
    
    public function all()
    {
        return new FullCommandStream($this->event_repo);
    }
}


