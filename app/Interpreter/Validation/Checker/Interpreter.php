<?php namespace App\Interpreter\Validation\Checker;

class Interpreter
{    
    private $interpreters;
    
    public function __construct($interpreters)
    {
        $this->interpreters = $interpreters;
    }
    
    public function check($value, $arguments=null)
    { 
        foreach ($this->interpreters as $interpreter) {
            if (!$interpreter->check($value, $arguments)) {
                return false;
            }
        }
        return true;
    }
}



