<?php namespace App\Interpreter\Aggregate;

use App\Interpreter\Modification;
use App\Interpreter\EventStore;
use App\Interpreter\Validation;

class Interpreter
{    
    private $aggregate_id;
    private $defaults;
        private $root_entity_id;
    private $validator;
    private $modifier;
    private $event_store;
    
    public function __construct(
        $ast, 
        Validation\Validator $validator,
        Modification\Modifier $modifier,
        EventStore $event_store
    )
    {
        $this->aggregate_id = $ast->id;
        $this->defaults = $ast->root->defaults;
        $this->root_entity_id = $ast->root->entity_id;
        
        $this->validator = $validator;
        $this->event_store = $event_store;
        
        $this->modifier = $modifier;
    }
    
    public function build_root($entity_id)
    {        
        $entity_defaults = clone $this->defaults;
        $entity_defaults->id = $entity_id;
        
        $root_entity = $this->validator->validate($this->root_entity_id, $entity_defaults);
        
        $events = $this->event_store->fetch($entity_id, $this->aggregate_id);
        
        foreach ($events as $event) {
            $id = $event->schema->id;
            $root_entity = $this->modifier->modify($id, $root_entity, $event);
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
        return $handler->modify($root_entity, $event);
    }
}



