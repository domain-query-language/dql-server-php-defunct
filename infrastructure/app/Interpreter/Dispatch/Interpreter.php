<?php namespace Infrastructure\App\Interpreter\Dispatch;

use App\Interpreter\HandlerRepository;
use App\Interpreter\AggregateRepository;
use Infrastructure\App\Interpreter\Handler;
use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Aggregate;
use Test\Interpreter\EventStore;

class Interpreter implements \App\Interpreter\Interpreter
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
        
    public function interpret(Context $context)
    {
        $aggregate_id = $context->get_property(['schema', 'aggregate_id']);
        
        $aggreate_ast = $this->aggregate_repo->fetch_ast($aggregate_id);
        $aggregate_interpreter = $this->aggregate_factory->ast($aggreate_ast);
                
        $aggregate_context = new Context($context->get_property('domain'));
        
        $root = $aggregate_interpreter->interpret($aggregate_context);
        
        $handler_context = new Context((object)[
            'command' => $context->get_property(['domain', 'payload']),
            'root' => $root
        ]);
        
        $handler_ast = $this->handler_repo->fetch_ast($context->get_property(['schema', 'id']));
        
        $handler = $this->handler_factory->ast($handler_ast);
                    
        $events = $handler->interpret($handler_context);
        $this->event_store->store($events);
        
        return $events;
    }
}