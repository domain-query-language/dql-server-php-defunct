<?php namespace App\Interpreter\Update;

class Interpreter extends \App\Interpreter\Query\Interpreter
{
    public function update($root) 
    {
        return parent::query($root);
    }
}