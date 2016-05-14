<?php

use Infrastructure\App\Interpreter\InterpreterPattern\Invariant;

class Fail implements \App\Interpreter\InvariantRepository
{
    public function fetch($id)
    {
        return new Invariant(true);
    }
}