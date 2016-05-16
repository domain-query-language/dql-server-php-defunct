<?php namespace Infrastructure\App\Interpreter\InterpreterPattern;

use App\Interpreter\InvariantRepository;
use App\Interpreter\Context;

class Check
{    
    private $invariant;
    private $comparator;
    
    public function __construct($ast, InvariantRepository $invariant_repo)
    {
        $this->invariant = $invariant_repo->fetch($ast->invariant_id);
        $this->arguments_interpreter = new Arguments($ast->arguments);
        $this->comparator = $ast->comparator;
    }
    
    public function interpret(Context $context)
    {
        $arguments = $this->arguments_interpreter->interpret($context);
        
        $result = $this->invariant->check($arguments);
        
        if ($this->comparator == 'not') {
            return !$result;
        }
        return $result;
    }
}



