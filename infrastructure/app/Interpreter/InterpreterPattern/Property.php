<?php namespace Infrastructure\App\Interpreter\InterpreterPattern;

class Property
{
    public $path;
    
    public function __construct($path)
    {
        $this->path = $path;
    }
    
    public function interpret($context)
    {
        $property = $context;
        foreach ($this->path as $path) {
            $property = $property->$path;
        }
        return $property;
    }
}

