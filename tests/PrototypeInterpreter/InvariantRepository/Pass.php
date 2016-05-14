<?php

use Infrastructure\App\Interpreter\InterpreterPattern\Invariant;

class Pass implements \App\Interpreter\InvariantRepository
{
    public function fetch($id)
    {
        return new Invariant(false);
    }
}