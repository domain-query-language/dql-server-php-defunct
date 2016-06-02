<?php namespace App\Interpreter\Aggregate;

use App\Interpreter\Context;
use App\Interpreter\EventHandlerRepository;
use App\Interpreter\EventHandler;
use Test\Interpreter\EventStore;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $aggregate_id;
    private $defaults;
    private $entity_interpreter;
    private $event_store;
    private $event_handler_repo;
    private $event_hander_factory;
    
    public function __construct(
        $aggregate_id, 
        $defaults, 
        $entity_interpreter, 
        EventStore $event_store,
        EventHandlerRepository $event_handler_repo,
        EventHandler\Factory $event_handler_factory
    )
    {
        $this->aggregate_id = $aggregate_id;
        $this->defaults = $defaults;
        $this->entity_interpreter = $entity_interpreter;
        $this->event_store = $event_store;
        
        $this->event_handler_repo = $event_handler_repo;
        $this->event_hander_factory = $event_handler_factory;
    }
    
    public function interpret(Context $context)
    { 
        $entity_id = $context->get_property('aggregate_id');
        
        $entity_defaults = clone $this->defaults;
        $entity_defaults->id = $entity_id;
        
        $entity_context = new Context($entity_defaults);
        
        $root_entity = $this->entity_interpreter->interpret($entity_context);
        
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
        $handler_context = new Context((object)[
            'root' => $root_entity,
            'event' => $event
        ]);

        $handler = $this->event_hander_factory->ast($handler_ast);
        $handler->interpret($handler_context);
    }
}



