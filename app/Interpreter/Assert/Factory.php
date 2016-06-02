<?php namespace App\Interpreter\Assert;

use App\Interpreter\InvariantRepository;
use App\Interpreter\Invariant;
use App\Interpreter\Arguments;

class Factory
{    
    private $invariant_repository;
    private $invariant_factory;
    
    public function __construct(
        InvariantRepository $invariant_repository, 
        Invariant\Factory $invariant_factory
    )
    {
        $this->invariant_repository = $invariant_repository;
        $this->invariant_factory = $invariant_factory;
    }
    
    public function ast($ast)
    {
        $invariant_ast = $this->invariant_repository->fetch_ast($ast->invariant_id);
        $invariant = $this->invariant_factory->ast($invariant_ast);
        $parameters = array_keys((array)$invariant_ast->parameters);
        $arguments = new Arguments\Interpreter($ast->arguments, $parameters);
        return new Interpreter($invariant, $arguments, $ast->comparator);
    }
}



