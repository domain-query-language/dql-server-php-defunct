<?php namespace App\Interpreter\Assert;

use App\Interpreter\InvariantException;
use App\Interpreter\Invariant;

class Interpreter
{    
    private $invariant;
    private $arguments;
    private $comparator;
    
    public function __construct(
        Invariant\Interpreter $invariant, 
        $comparator)
    {
        $this->invariant = $invariant;
        $this->comparator = $comparator;
    }
    
    public function interpret($root, $command)
    {
        $result = $this->invariant->interpret($root);

        if ($this->comparator == 'not') {
            $result = !$result;
        }
        
        if (!$result) {
            throw new InvariantException("Failure");
        }
    }
}



