<?php namespace App\Interpreter\Handler;

use App\Interpreter\Handler\Statement;

class Factory 
{   
    private $statement_factory;
    
    public function __construct(Statement\Factory $statement_factory)
    {
        $this->statement_factory = $statement_factory;
    }
    
    public function ast($ast)
    {
        $statements = array_map(function($statement_ast) {
            return $this->statement_factory->ast($statement_ast);
        }, $ast->statements);
        
        return new Interpreter($statements);
    }   
}