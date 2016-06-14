<?php namespace App\Interpreter\Query;

class NullInterpreter
{   
    public function query($root)
    {        
        return $root;
    }
}

