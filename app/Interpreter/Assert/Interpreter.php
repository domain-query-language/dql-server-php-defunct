<?php namespace App\Interpreter\Assert;

use App\Interpreter\InvariantException;
use App\Interpreter\Invariant;
use App\Interpreter\Arguments;

class Interpreter
{    
    private $invariant;
    private $arguments;
    private $comparator;
    
    public function __construct(
        Invariant\Interpreter $invariant, 
        Arguments\Interpreter $arguments, 
        $comparator)
    {
        $this->invariant = $invariant;
        $this->arguments = $arguments;
        $this->comparator = $comparator;
    }
    
    public function interpret($data)
    {
        $context = new \App\Interpreter\Context($data);
        $arguments_context = $this->arguments->interpret($context);
        
        $result = $this->invariant->interpret($arguments_context);

        if ($this->comparator == 'not') {
            $result = !$result;
        }
        
        if (!$result) {
            throw new InvariantException("Failure");
        }
    }
}



