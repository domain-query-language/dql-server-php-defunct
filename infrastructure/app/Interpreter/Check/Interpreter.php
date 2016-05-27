<?php namespace Infrastructure\App\Interpreter\Check;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $interpreters;
    
    public function __construct($interpreters)
    {
        $this->interpreters = $interpreters;
    }
    
    public function interpret(Context $context)
    { 
        foreach ($this->interpreters as $interprter) {
            if (!$interprter->interpret($context)) {
                return false;
            }
        }
        return true;
    }
}



