<?php namespace App\Interpreter\Dispatch;

use App\Interpreter\Handler;
use App\Interpreter\Aggregate;
use App\Interpreter\EventStore;
use App\Interpreter\CommandStore;

class Dispatcher
{
    private $handler;
    private $aggregate;
    private $event_store;
    private $command_store;
    
    public function __construct( 
        Handler\Handler $handler,
        Aggregate\Aggregate $aggregate,
        EventStore $event_store,
        CommandStore $command_store
    )
    {
        $this->handler = $handler;
        $this->aggregate = $aggregate;
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
        $aggregate_id = $command->schema->aggregate_id;
        $entity_id = $command->domain->aggregate_id;
        $root_entity = $this->aggregate->build_root($aggregate_id, $entity_id);

        $command_id = $command->schema->id;
        $payload = $command->domain->payload;
        
        $events = $this->handler->handle($command_id, $root_entity, $payload);
        
        return $this->decorate_events_with_command_id($events, $command);
    }
    
    private function decorate_events_with_command_id($events, $command)
    {
        return array_map(function($event) use ($command){
            $event->domain->command_id = $command->domain->id;
            return $event;
        }, $events);
    }
}