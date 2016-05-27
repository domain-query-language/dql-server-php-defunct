<?php namespace Infrastructure\App\Interpreter\Assert;

use App\Interpreter\InvariantRepository;
use Infrastructure\App\Interpreter\Invariant;
use Infrastructure\App\Interpreter\Arguments;

class Factory
{    
    private $invariant_repository;
    private $invariant_factory;
    private $parameter_scanner;
    
    public function __construct(
        InvariantRepository $invariant_repository, 
        Invariant\Factory $invariant_factory,
        Invariant\ParameterScanner $parameter_scanner
    )
    {
        $this->invariant_repository = $invariant_repository;
        $this->invariant_factory = $invariant_factory;
        $this->parameter_scanner = $parameter_scanner;
    }
    
    public function ast($ast)
    {
        $invariant_ast = $this->invariant_repository->fetch_ast($ast->invariant_id);
        $invariant = $this->invariant_factory->ast($invariant_ast);
        $parameters = $this->parameter_scanner->scan($invariant_ast);
        $arguments = new Arguments\Interpreter($ast->arguments, $parameters);
        return new Interpreter($invariant, $arguments, $ast->comparator);
    }
}



