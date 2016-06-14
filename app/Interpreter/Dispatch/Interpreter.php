<?php namespace App\Interpreter\Dispatch;

use App\Interpreter\HandlerRepository;
use App\Interpreter\AggregateRepository;
use App\Interpreter\Handler;
use App\Interpreter\Aggregate;
use Test\Interpreter\EventStore;

class Interpreter
{
    private $handler_repo;
    private $handler_factory;
    private $aggregate_repo;
    private $aggregate_factory;
    private $event_store;
    
    public function __construct(
        HandlerRepository $handler_repo, 
        Handler\Factory $handler_factory,
        AggregateRepository $aggregate_repo,
        Aggregate\Factory $aggregate_factory,
        EventStore $event_store
    )
    {
        $this->handler_repo = $handler_repo;
        $this->handler_factory = $handler_factory;
        $this->aggregate_repo = $aggregate_repo;
        $this->aggregate_factory = $aggregate_factory;
        $this->event_store = $event_store;
    }
        
    public function interpret($command)
    {
        $root_entity = $this->build_root_entity($command);
                
        $events = $this->handle_command($command, $root_entity);
        
        $this->event_store->store($events);
        
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
        $handler_ast = $this->handler_repo->fetch_ast($command->schema->id);
        
        $handler = $this->handler_factory->ast($handler_ast);
                    
        return $handler->interpret($root_entity, $command->domain->payload);
    }
}