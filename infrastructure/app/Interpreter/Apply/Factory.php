<?php namespace Infrastructure\App\Interpreter\Apply;

use App\Interpreter\EventRepository;
use Infrastructure\App\Interpreter\Check;
use Infrastructure\App\Interpreter\Event;
use Infrastructure\App\Interpreter\Arguments;

class Factory 
{   
    private $event_repository;
    private $event_factory;
    private $check_factory;
    
    public function __construct(
        EventRepository $event_repository, 
        Event\Factory $event_factory,
        Check\Factory $check_factory
    )
    {
        $this->event_repository = $event_repository;
        $this->event_factory = $event_factory;
        $this->check_factory = $check_factory;
    }
    
    public function ast($ast)
    {
        $event_ast = $this->event_repository->fetch_ast($ast->event_id);
        $parameters = $this->event_parameters($event_ast);
        $arguments_interpreter = new Arguments\Interpreter($ast->arguments, $parameters);
        $event_interpreter = $this->event_factory->ast($event_ast);
        
        return new Interpreter($arguments_interpreter, $event_interpreter);
    }   
    
    private function event_parameters($ast)
    {
        return array_keys((array)$ast->children);
    }
}