<?php

namespace Infrastructure\App\Interpreter\InterpreterPattern\Repository;

interface Event
{
    public function fetch($id);
}

