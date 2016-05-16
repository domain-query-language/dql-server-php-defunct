<?php

use Infrastructure\App\Interpreter\InterpreterPattern\Invariant;

class Fail implements \App\Interpreter\InvariantRepository
{
    private $invariant_class;
    
    public function __construct($invariant_class)
    {
        $this->invariant_class = $invariant_class;
    }
    
    public function fetch($id)
    {
        return new $this->invariant_class(true);
    }
}