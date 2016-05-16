<?php namespace Infrastructure\App\Interpreter\InterpreterPattern;

use App\Interpreter\InvariantRepository;
use App\Interpreter\Context;

class Statement
{    
    private $interpreter;
    
    public function __construct($ast, InvariantRepository $invariant_repo)
    {
        if ($ast->assert) {
            $this->interpreter = new Assert($ast->assert, $invariant_repo);
        } else {
            $this->interpreter = new Apply($ast->apply, $invariant_repo);
        }
    }
    
    public function interpret(Context $context)
    {
        return $this->interpreter->interpret($context);
    }
}

