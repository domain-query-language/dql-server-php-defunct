<?php namespace Infrastructure\App\Interpreter\VisitorPattern\AST;

class Assert
{
    public $invariant_id;
    public $comparator;
    public $arguments;
    
    public function __construct($ast)
    {
        $this->invariant_id = $ast->invariant_id;
        $this->comparator = $ast->comparator;
        $this->arguments = array_map(function($argument_ast){
            return new Argument($argument_ast);
        }, $ast->arguments);
    }
}