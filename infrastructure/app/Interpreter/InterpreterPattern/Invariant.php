<?php namespace Infrastructure\App\Interpreter\InterpreterPattern;

class Invariant
{
    private $result;
    
    public function __construct($result)
    {
        $this->result = $result;
    }
    
    public function check($arguments)
    {
        return $this->result;
    }
}

