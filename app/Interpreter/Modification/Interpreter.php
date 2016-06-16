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
            $value = $this->get_value($statement->value, $event);
            if ($statement->type == 'set') {
                $root->$property = $value;
            } else if ($statement->type == 'add_to') {
                $root->$property[] = $value;
            } else if ($statement->type == 'remove_from') {
                $root->$property = $this->remove_from_list($root->$property, $value);
            }
        }
        return $root;
    }
    
    private function remove_from_list($list, $value)
    {
        $list = array_filter($list, function($element) use ($value){
            if (isset($element->id)) {
                return !($element->id == $value);
            } else {
                return !($element == $value);
            }
        });
        return array_values($list);
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

