<?php namespace App\Interpreter\EventHandler;

class Interpreter
{   
    private $statements;
    
    public function __construct($statements)
    {
        $this->statements = $statements;
    }
    
    public function modify($root, $event)
    {        
        foreach ($this->statements as $statement) {
            $property = $statement->property;
            $root->$property = $this->get_value($statement->value, $event);
        }
        return $root;
    }
    
    private function get_value($ast, $event)
    {
        if (isset($ast->literal)) {
            return $ast->literal;
        }
    }
}

