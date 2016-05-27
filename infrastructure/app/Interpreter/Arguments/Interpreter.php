<?php namespace Infrastructure\App\Interpreter\Arguments;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $arguments;
    private $properties;
    
    public function __construct($arguments, $properties)
    {
        $this->arguments = $arguments;
        $this->properties = $properties;
    }
    
    public function interpret(Context $context)
    {
        foreach ($this->properties as $key=>$property) {
            $value = $context->get_property($this->arguments[$key]);
            $context = $context->set_property($property, $value);
        }
        return $context;
    }
}




