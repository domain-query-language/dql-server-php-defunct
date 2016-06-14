<?php namespace App\Interpreter\Modification;

class NullInterpreter
{   
    public function modify($root, $event)
    {        
        return $root;
    }
}

