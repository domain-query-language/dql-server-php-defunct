<?php namespace Infrastructure\App\Interpreter\Check;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $invariant;
    private $comparator;
    
    public function __construct($invariant, $arguments_interpreter, $comparator)
    {
        $this->invariant = $invariant;
        $this->arguments_interpreter = $arguments_interpreter;
        $this->comparator = $comparator;
    }
    
    public function interpret(Context $context)
    {
        $arguments = $this->arguments_interpreter->interpret($context);
        
        $result = $this->invariant->interpret($arguments);
                
        if ($this->comparator == 'not') {
            return !$result;
        }
       
        return $result;
    }
}



