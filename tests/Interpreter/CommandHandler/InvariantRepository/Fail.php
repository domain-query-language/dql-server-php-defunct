<?php

class Fail implements \App\Interpreter\InvariantRepository
{
    public function fetch_ast($id)
    {
        return true;
    }
}