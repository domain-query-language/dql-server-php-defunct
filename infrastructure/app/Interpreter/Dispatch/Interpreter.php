<?php namespace Infrastructure\App\Interpreter\Dispatch;

use App\Interpreter\HandlerRepository;
use App\Interpreter\AggregateRepository;
use App\Interpreter\EntityRepository;
use Infrastructure\App\Interpreter\Handler;
use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{
    private $handler_repo;
    private $handler_factory;
    private $aggregate_repo;
    private $entity_repo;
    
    public function __construct(
        HandlerRepository $handler_repo, 
        Handler\Factory $handler_factory
        //AggregateRepository $aggregate_repo,
        //EntityRepository $entity_repo
    )
    {
        $this->handler_repo = $handler_repo;
        $this->handler_factory = $handler_factory;
        //$this->aggregate_repo = $aggregate_repo;
        //$this->entity_repo = $entity_repo;
    }
        
    public function interpret(Context $context)
    {
        $aggregate_id = $context->get_property(['domain', 'aggregate_id']);
        $handler_ast = $this->handler_repo->fetch_ast($context->get_property(['schema', 'id']));
        
        $handler = $this->handler_factory->ast($handler_ast);
                
        $handler_context = new Context((object)[
            'command' => $context->get_property(['domain', 'payload']),
            'root' => (object)[
                'id'=>$aggregate_id,
                'is_created' => false
            ]
        ]);
     
        return $handler->interpret($handler_context);
    }
}