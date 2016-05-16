<?php namespace Infrastructure\App\Interpreter\VisitorPattern\AST;

class Invariant
{
    public $result;
    
    public function __construct($result)
    {
        $this->result = $result;
    }
}