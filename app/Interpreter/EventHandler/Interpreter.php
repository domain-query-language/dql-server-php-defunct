<?php namespace App\Interpreter\EventHandler;

class Interpreter implements \App\Interpreter\Interpreter
{   
    private $statements;
    
    public function __construct($statements)
    {
        $this->statements = $statements;
    }
    
    public function interpret(\App\Interpreter\Context $context)
    {
        $root = $context->get_property('root');
        $event = $context->get_property('event');
        
        foreach ($this->statements as $statement) {
            $property = $statement->property;
            $root->$property = $this->get_value($statement->value, $event);
        }
    }
    
    private function get_value($ast, $event)
    {
        if (isset($ast->literal)) {
            return $ast->literal;
        }
    }
}

