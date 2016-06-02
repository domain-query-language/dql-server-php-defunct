<?php namespace App\Interpreter\Compare;

class Interpreter implements \App\Interpreter\Interpreter
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
    
    public function interpret(\App\Interpreter\Context $context)
    {
        $value = $context->get_property($this->property);
        
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

