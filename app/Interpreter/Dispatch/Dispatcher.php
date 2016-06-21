<?php namespace App\Interpreter\Dispatch;

use App\Interpreter\Handler;
use App\Interpreter\Aggregate;
use App\Interpreter\EventStore;
use App\Interpreter\CommandStore;

class Dispatcher
{
    private $handler;
    private $aggregate_root_builder;
    private $event_store;
    private $command_store;
    
    public function __construct( 
        Handler\Handler $handler,
        Aggregate\Aggregate $aggregate_root_builder,
        EventStore $event_store,
        CommandStore $command_store
    )
    {
        $this->handler = $handler;
        $this->aggregate_root_builder = $aggregate_root_builder;
        $this->event_store = $event_store;
        $this->command_store = $command_store;
    }
        
    public function dispatch($command)
    {                
        $events = $this->handle_command($command);

        $this->event_store->store($events);
        $this->command_store->store([$command]);
        
        return $events;
    }
    
    private function handle_command($command)
    {
        $root_entity = $this->build_root_adapter($command);

        $events = $this->handle_command_adapter($command, $root_entity);
        
        return $this->decorate_events_with_command_id($events, $command);
    }
    
    private function build_root_adapter($command)
    {
        $aggregate_id = $command->schema->aggregate_id;
        $entity_id = $command->domain->aggregate_id;
        
        return $this->aggregate_root_builder->build_root($aggregate_id, $entity_id);
    }
    
    private function handle_command_adapter($command, $root_entity)
    {
        $command_ast_id = $command->schema->id;
        $payload = $command->domain->payload;
        
        return $this->handler->handle($command_ast_id, $root_entity, $payload);
    }
     
    private function decorate_events_with_command_id($events, $command)
    {
        return array_map(function($event) use ($command){
            $event->domain->command_id = $command->domain->id;
            return $event;
        }, $events);
    }
}