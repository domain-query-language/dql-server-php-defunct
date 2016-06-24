<?php namespace App\Interpreter\Handler\Assert;

use App\Interpreter\AstRepository;
use App\Interpreter\Handler\Invariant;

class Factory
{    
    private $ast_repository;
    private $invariant_factory;
    
    public function __construct(
        AstRepository $ast_repository, 
        Invariant\Factory $invariant_factory
    )
    {
        $this->ast_repository = $ast_repository;
        $this->invariant_factory = $invariant_factory;
    }
    
    public function ast($ast)
    {
        $invariant_ast = $this->ast_repository->fetch($ast->invariant_id);
        $invariant = $this->invariant_factory->ast($invariant_ast);
        return new Interpreter($invariant, $ast->comparator);
    }
}



