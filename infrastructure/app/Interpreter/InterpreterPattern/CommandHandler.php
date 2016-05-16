<?php namespace Infrastructure\App\Interpreter\InterpreterPattern;

use App\Interpreter\InvariantRepository;
use App\Interpreter\Context;

class CommandHandler implements \App\Interpreter\Interpreter
{
    private $statements = [];
    
    public function __construct(InvariantRepository $invariant_repository, $ast)
    {
        foreach ($ast->statements as $statement_ast) {
            $this->statements[] = new Statement($statement_ast, $invariant_repository);
        }
    }
        
    public function interpret(Context $context)
    {
        $this->context = $context;
        $events = [];
        foreach ($this->statements as $statement) {
           $events[] = $statement->interpret($context); 
        }  
        return array_values(array_filter($events));
    }
}