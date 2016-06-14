<?php namespace App\Interpreter;

class NullInterpreter
{
    public function interpret($data)
    {
        return $data;
    }
}
