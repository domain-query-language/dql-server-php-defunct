<?php namespace Infrastructure\App\Interpreter\Dispatch;

use App\Interpreter\HandlerRepository;
use Infrastructure\App\Interpreter\Handler;
use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{
    private $handler_repo;
    private $handler_factory;
    
    public function __construct(HandlerRepository $handler_repo, Handler\Factory $handler_factory)
    {
        $this->handler_repo = $handler_repo;
        $this->handler_factory = $handler_factory;
    }
        
    public function interpret(Context $context)
    {
        $handler_ast = $this->handler_repo->fetch_ast($context->get_property(['schema', 'id']));
        
        $handler = $this->handler_factory->ast($handler_ast);
                
        $handler_context = new Context((object)[
            'command' => $context->get_property(['domain', 'payload']),
            'root' => (object)[
                'id'=>"ff3a666b-4288-4ecd-86d7-7f511a2fd378",
                'is_created' => false
            ]
        ]);
     
        return $handler->interpret($handler_context);
    }
}