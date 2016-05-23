<?php namespace Infrastructure\App\Interpreter\Compare;

class Interpreter implements \App\Interpreter\Interpreter
{
    private $comparator;
    private $value;
    
    public function __construct($comparator, $value)
    {
        $this->comparator = $comparator;
        $this->value = $value;
    }
    
    public function interpret(\App\Interpreter\Context $context)
    {
        $value = $context->get_property('value');
        if ($this->comparator == ">"){
            if ($value > $this->value) {
                return $value;
            }
            throw new Exception("Invalid value");
        }
    }
}

