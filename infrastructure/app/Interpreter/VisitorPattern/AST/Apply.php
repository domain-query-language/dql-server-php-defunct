<?php namespace Infrastructure\App\Interpreter\VisitorPattern\AST;

class Apply
{
    public $event_id;
    public $arguments;
    
    public function __construct($ast)
    {
        $this->event_id = $ast->event_id;
        $this->arguments = array_map(function($argument_ast){
            return new Argument($argument_ast);
        }, $ast->arguments);
    }
}