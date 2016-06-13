<?php namespace App\Interpreter\Aggregate;

use App\Interpreter\Validation;
use App\Interpreter\EventHandlerRepository;
use App\Interpreter\EventHandler;
use Test\Interpreter\EventStore;

class Factory
{    
    private $validator;
    private $event_store;
    private $event_handler_repo;
    private $event_hander_factory;
    
    public function __construct(
        Validation\Validator $validator,
        EventStore $event_store,
        EventHandlerRepository $event_handler_repo,
        EventHandler\Factory $event_hander_factory
    )
    {
        $this->validator = $validator;
        $this->event_store = $event_store;
        
        $this->event_handler_repo = $event_handler_repo;
        $this->event_hander_factory = $event_hander_factory;
    }
    
    public function ast($ast)
    {
        return new Interpreter(
            $ast,
            $this->validator,
            $this->event_store,
            $this->event_handler_repo,
            $this->event_hander_factory
        );
    }
}



