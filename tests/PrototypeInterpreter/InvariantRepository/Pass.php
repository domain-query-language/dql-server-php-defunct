<?php

class Pass implements \App\Interpreter\InvariantRepository
{
    public function fetch($id)
    {
        return new \Infrastructure\App\Interpreter\InterpreterPattern\Invariant(false);
    }
}