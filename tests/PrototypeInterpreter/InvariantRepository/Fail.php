<?php

class Fail implements \App\Interpreter\InvariantRepository
{
    public function fetch($id)
    {
        return new \Infrastructure\App\Interpreter\InterpreterPattern\Invariant(true);
    }
}