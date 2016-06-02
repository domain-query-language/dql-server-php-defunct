<?php namespace App\Interpreter\Aggregate;

use App\Interpreter\EntityRepository;
use App\Interpreter\Entity;
use App\Interpreter\EventHandlerRepository;
use App\Interpreter\EventHandler;
use Test\Interpreter\EventStore;

class Factory
{    
    private $entity_repository;
    private $entity_factory;
    private $event_store;
    private $event_handler_repo;
    private $event_hander_factory;
    
    public function __construct(
        EntityRepository $entity_repository, 
        Entity\Factory $entity_factory,
        EventStore $event_store,
        EventHandlerRepository $event_handler_repo,
        EventHandler\Factory $event_hander_factory
    )
    {
        $this->entity_repository = $entity_repository;
        $this->entity_factory = $entity_factory;
        $this->event_store = $event_store;
        
        $this->event_handler_repo = $event_handler_repo;
        $this->event_hander_factory = $event_hander_factory;
    }
    
    public function ast($ast)
    {
        $entity_ast = $this->entity_repository->fetch_ast($ast->root->entity_id);
        $entity_interpreter = $this->entity_factory->ast($entity_ast);
                
        return new Interpreter(
            $ast->id, 
            $ast->root->defaults, 
            $entity_interpreter, 
            $this->event_store,
            $this->event_handler_repo,
            $this->event_hander_factory
        );
    }
}



