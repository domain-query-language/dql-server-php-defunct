<?php namespace App\Interpreter\Aggregate;

use App\Interpreter\AstRepository;

class Aggregate
{    
    private $ast_repo;
    private $factory;
 
    public function __construct(AstRepository $ast_repo, Factory $factory)
    {
        $this->ast_repo = $ast_repo;
        $this->factory = $factory;
    }
    
    public function build_root($id, $entity_id)
    {
        $ast = $this->ast_repo->fetch($id);
        $interpreter = $this->factory->ast($ast);
        return $interpreter->build_root($entity_id);
    }
}



