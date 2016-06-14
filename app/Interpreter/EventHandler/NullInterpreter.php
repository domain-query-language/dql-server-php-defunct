<?php namespace App\Interpreter\EventHandler;

class NullInterpreter
{   
    public function modify($root, $event)
    {        
        return $root;
    }
}

