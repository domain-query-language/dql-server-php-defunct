<?php namespace App\Interpreter\Modification;

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
            if ($statement->type == 'set') {
                $root->$property = $this->get_value($statement->value, $event);
            } else if ($statement->type == 'add') {
                $root->$property[] = $this->get_value($statement->value, $event);
            }
        }
        return $root;
    }
    
    private function get_value($ast, $event)
    {
        if (isset($ast->literal)) {
            return $ast->literal;
        } else if (isset($ast->property)) {
            $key = $ast->property[0];
            return $event->$key;
        }
    }
}

