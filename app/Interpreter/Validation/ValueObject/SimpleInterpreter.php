<?php namespace App\Interpreter\Validation\ValueObject;

class SimpleInterpreter
{    
    private $check;
    
    public function __construct($check)
    {
        $this->check = $check;
    }
    
    public function validate($value)
    { 
        if (!$this->check->check($value)) {
            throw new ValueException();
        }
        return $value;
    }
}



