<?php namespace App\Interpreter\Handler\Apply;

use App\Interpreter\AstRepository;
use App\Interpreter\Event;
use App\Interpreter\Handler\Assert;
use App\Interpreter\Modification;

class Factory 
{   
    private $event_repository;
    private $event_factory;
    private $assert_factory;
    private $event_handlers;
    
    public function __construct(
        AstRepository $event_repository, 
        Event\Factory $event_factory,
        Assert\Factory $assert_factory,
        Modification\Modifier $event_handlers
    )
    {
        $this->event_repository = $event_repository;
        $this->event_factory = $event_factory;
        $this->assert_factory = $assert_factory;
        $this->event_handlers = $event_handlers;
    }
    
    public function ast($ast)
    {
        $assert_interpreter = isset($ast->assert)
            ? $this->assert_factory->ast($ast->assert)
            : null;
        
        $event_ast = $this->event_repository->fetch($ast->event_id);

        $event_interpreter = $this->event_factory->ast($event_ast);
               
        return new Interpreter(
            $event_interpreter, 
            $assert_interpreter, 
            $ast->event_id, 
            $this->event_handlers
        );
    }   
}