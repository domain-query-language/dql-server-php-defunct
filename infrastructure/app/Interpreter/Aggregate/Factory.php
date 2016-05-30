<?php namespace Infrastructure\App\Interpreter\Aggregate;

use App\Interpreter\EntityRepository;
use Infrastructure\App\Interpreter\Entity;

class Factory
{    
    private $entity_repository;
    private $entity_factory;
    
    public function __construct(
        EntityRepository $entity_repository, 
        Entity\Factory $entity_factory
    )
    {
        $this->entity_repository = $entity_repository;
        $this->entity_factory = $entity_factory;
    }
    
    public function ast($ast)
    {
        $entity_ast = $this->entity_repository->fetch_ast($ast->root->entity_id);
        $entity_interpreter = $this->entity_factory->ast($entity_ast);
                
        return new Interpreter($ast->root->defaults, $entity_interpreter);
    }
}



