<?php namespace App\Interpreter\Apply;

use App\Interpreter\EventRepository;
use App\Interpreter\Event;
use App\Interpreter\Modification;

class Factory 
{   
    private $event_repository;
    private $event_factory;
    private $modification;
    
    public function __construct(
        EventRepository $event_repository, 
        Event\Factory $event_factory,
        Modification\Modifier $modification
    )
    {
        $this->event_repository = $event_repository;
        $this->event_factory = $event_factory;
        $this->modification = $modification;
    }
    
    public function ast($ast)
    {
        $event_ast = $this->event_repository->fetch_ast($ast->event_id);

        $event_interpreter = $this->event_factory->ast($event_ast);
                
        return new Interpreter($event_interpreter, $ast->event_id, $this->modification);
    }   
}