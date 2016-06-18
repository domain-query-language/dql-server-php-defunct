<?php namespace App\Interpreter\Dispatch;

use App\Interpreter\Handler;
use App\Interpreter\AggregateRepository;
use App\Interpreter\Aggregate;
use App\Interpreter\EventStore;
use App\Interpreter\CommandStore;

class Dispatcher
{
    private $handler;
    private $aggregate_repo;
    private $aggregate_factory;
    private $event_store;
    private $command_store;
    
    public function __construct( 
        Handler\Handler $handler,
        AggregateRepository $aggregate_repo,
        Aggregate\Factory $aggregate_factory,
        EventStore $event_store,
        CommandStore $command_store
    )
    {
        $this->handler = $handler;
        $this->aggregate_repo = $aggregate_repo;
        $this->aggregate_factory = $aggregate_factory;
        $this->event_store = $event_store;
        $this->command_store = $command_store;
    }
        
    public function dispatch($command)
    {
        $root_entity = $this->build_root_entity($command);
                
        $events = $this->handle_command($command, $root_entity);
        
        $this->event_store->store($events);
        $this->command_store->store([$command]);
        
        return $events;
    }
    
    private function build_root_entity($command)
    {
        $aggregate_id = $command->schema->aggregate_id;
        
        $aggreate_ast = $this->aggregate_repo->fetch_ast($aggregate_id);
        $aggregate_interpreter = $this->aggregate_factory->ast($aggreate_ast);
        
        return $aggregate_interpreter->build_root($command->domain->aggregate_id);
    }
    
    private function handle_command($command, $root_entity)
    {
        $aggregate_id = $command->schema->id;
        $payload = $command->domain->payload;
        $events = $this->handler->handle($aggregate_id, $root_entity, $payload);
        
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