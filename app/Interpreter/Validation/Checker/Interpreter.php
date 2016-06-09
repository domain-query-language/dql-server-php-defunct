<?php namespace App\Interpreter\Validation\Checker;

class Interpreter
{    
    private $interpreters;
    
    public function __construct($interpreters)
    {
        $this->interpreters = $interpreters;
    }
    
    public function check($value)
    { 
        foreach ($this->interpreters as $interprter) {
            if (!$interprter->check($value)) {
                return false;
            }
        }
        return true;
    }
}



