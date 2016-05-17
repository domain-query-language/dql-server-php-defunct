<?php namespace Infrastructure\App\Interpreter\InterpreterPattern\Check;

use App\Interpreter\InvariantRepository;
use Infrastructure\App\Interpreter\InterpreterPattern\Arguments;

class Factory 
{    
    private $invariant_repo;
    
    public function __construct(InvariantRepository $invariant_repo)
    {
        $this->invariant_repo = $invariant_repo;
    }
    
    public function ast($ast)
    {
        $invariant = $this->invariant_repo->fetch($ast->invariant_id);
        
        $arguments_interpreter = new Arguments\Interpreter($ast->arguments);
        
        return new Interpreter($invariant, $arguments_interpreter, $ast->comparator);
    }
}



