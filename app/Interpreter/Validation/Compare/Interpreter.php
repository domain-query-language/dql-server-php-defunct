<?php namespace App\Interpreter\Validation\Compare;

class Interpreter
{
    private $property;
    private $comparator;
    private $value;
    
    public function __construct($property, $comparator, $value)
    {
        $this->property = $property;
        $this->comparator = $comparator;
        $this->value = $value;
    }
    
    public function check($value)
    {
        if ($this->comparator == "="){
            return $value == $this->value;
        }
        if ($this->comparator == "!="){
            return $value != $this->value;
        }
        if ($this->comparator == ">"){
            return $value > $this->value;
        }

        throw new Exception("Unknown comparator $this->comparator");
    }
}

