<?php namespace Infrastructure\App\Interpreter\VisitorPattern\AST;

class Argument
{
    public $property;
   
    public function __construct($ast)
    {
        $this->property = $ast->property;
    }
}