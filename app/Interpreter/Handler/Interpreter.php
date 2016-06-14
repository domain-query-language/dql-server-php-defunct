<?php namespace App\Interpreter\Handler;

class Interpreter
{
    private $statements = [];
    
    public function __construct($statements)
    {
        $this->statements = $statements;
    }
        
    public function interpret($root, $command)
    {
        $events = [];
        foreach ($this->statements as $statement) {
           $events[] = $statement->interpret($root, $command); 
        }  
        return array_values(array_filter($events));
    }
}