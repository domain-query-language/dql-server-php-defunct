<?php namespace Infrastructure\App\Interpreter\InterpreterPattern;

use App\Interpreter\InvariantRepository;
use App\Interpreter\Context;
use App\Interpreter\InvariantException;

class Assert
{    
    private $interpreter;
    
    public function __construct($ast, InvariantRepository $invariant_repo)
    {
        $this->interpreter = new Check($ast, $invariant_repo);
    }
    
    public function interpret(Context $context)
    {
        if (!$this->interpreter->interpret($context)) {
            throw new InvariantException("Failure");
        }
    }
}



