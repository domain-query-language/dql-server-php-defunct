<?php namespace App\Interpreter\Aggregate;

use App\Interpreter\EventHandlerRepository;
use App\Interpreter\EventHandler;
use Test\Interpreter\EventStore;
use App\Interpreter\Validation;

class Interpreter
{    
    private $aggregate_id;
    private $defaults;
    private $validator;
    private $root_entity_id;
    private $event_store;
    private $event_handler_repo;
    private $event_hander_factory;
    
    public function __construct(
        $ast, 
        Validation\Validator $validator,
        EventStore $event_store,
        EventHandlerRepository $event_handler_repo,
        EventHandler\Factory $event_handler_factory
    )
    {
        $this->aggregate_id = $ast->id;
        $this->defaults = $ast->root->defaults;
        $this->root_entity_id = $ast->root->entity_id;
        
        $this->validator = $validator;
        $this->event_store = $event_store;
        
        $this->event_handler_repo = $event_handler_repo;
        $this->event_hander_factory = $event_handler_factory;
    }
    
    public function build_root($aggregate_id)
    { 
        $entity_id = $aggregate_id;
        
        $entity_defaults = clone $this->defaults;
        $entity_defaults->id = $entity_id;
        
        $root_entity = $this->validator->validate($this->root_entity_id, $entity_defaults);
        
        $events = $this->event_store->fetch($entity_id, $this->aggregate_id);
        
        foreach ($events as $event) {
            $this->handle_event($root_entity, $event);
        }
        
        return $root_entity;
    }
    
    private function handle_event($root_entity, $event)
    {
        $handler_ast = $this->event_handler_repo->fetch_ast($event->schema->id);
        if (!$handler_ast) {
            return;
        }

        $handler = $this->event_hander_factory->ast($handler_ast);
        $handler->interpret($root_entity, $event);
    }
}



