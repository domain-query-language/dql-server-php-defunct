<?php namespace App\Interpreter\Validation\Validator;

class Interpreter
{
    private $validator;
    private $values;
    
    public function __construct($validator, $values)
    {
        $this->validator = $validator;
        $this->values = $values;
    }
    
    public function check($value)
    {
        if ($this->validator == "regex"){
            return (preg_match($this->values[0], $value) === 1);
        }
        if ($this->validator == "boolType"){
            return is_bool($value);
        }
    }
}

