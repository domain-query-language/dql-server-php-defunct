<?php namespace App\Interpreter\Handler\Assert;

use App\Interpreter\Handler\Invariant;

class Interpreter
{    
    private $invariant;
    private $comparator;
    
    public function __construct(Invariant\Interpreter $invariant, $comparator)
    {
        $this->invariant = $invariant;
        $this->comparator = $comparator;
    }
    
    public function interpret($root, $command)
    {
        $result = $this->check($root, $command);
        
        if (!$result) {
            throw new Invariant\Exception("Failure");
        }
    }
    
    public function check($root, $command) 
    {
        $result = $this->invariant->check($root, $command);

        if ($this->comparator == 'not') {
            $result = !$result;
        }
        
        return $result;
    }
}



