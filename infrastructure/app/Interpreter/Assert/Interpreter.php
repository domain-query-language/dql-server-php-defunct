<?php namespace Infrastructure\App\Interpreter\Assert;

use App\Interpreter\Context;
use App\Interpreter\InvariantException;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $interpreter;
    
    public function __construct($interpreter)
    {
        $this->interpreter = $interpreter;
    }
    
    public function interpret(Context $context)
    {
        if (!$this->interpreter->interpret($context)) {
            throw new InvariantException("Failure");
        }
    }
}



