<?php namespace Infrastructure\App\Interpreter\Apply;

use App\Interpreter\EventRepository;
use App\Interpreter\EventHandlerRepository;
use Infrastructure\App\Interpreter\Check;
use Infrastructure\App\Interpreter\Event;
use Infrastructure\App\Interpreter\Arguments;
use Infrastructure\App\Interpreter\NullInterpreter;
use Infrastructure\App\Interpreter\EventHandler;

class Factory 
{   
    private $event_repository;
    private $event_factory;
    private $check_factory;
    private $event_handler_repository;
    private $event_handler_factory;
    
    public function __construct(
        EventRepository $event_repository, 
        Event\Factory $event_factory,
        Check\Factory $check_factory,
        EventHandlerRepository $event_handler_repository,
        EventHandler\Factory $event_handler_factory
    )
    {
        $this->event_repository = $event_repository;
        $this->event_factory = $event_factory;
        $this->check_factory = $check_factory;
        $this->event_handler_repository = $event_handler_repository;
        $this->event_handler_factory = $event_handler_factory;
    }
    
    public function ast($ast)
    {
        $event_ast = $this->event_repository->fetch_ast($ast->event_id);
        $parameters = $this->event_parameters($event_ast);
        $arguments_interpreter = new Arguments\Interpreter($ast->arguments, $parameters);
        $event_interpreter = $this->event_factory->ast($event_ast);
        
        $event_handler_ast = $this->event_handler_repository->fetch_ast($ast->event_id);
        $event_handler_interpreter = new NullInterpreter();
        if ($event_handler_ast) {
            $event_handler_interpreter = $this->event_handler_factory->ast($event_handler_ast);
        }
        
        return new Interpreter($arguments_interpreter, $event_interpreter, $event_handler_interpreter);
    }   
    
    private function event_parameters($ast)
    {
        return array_keys((array)$ast->children);
    }
}