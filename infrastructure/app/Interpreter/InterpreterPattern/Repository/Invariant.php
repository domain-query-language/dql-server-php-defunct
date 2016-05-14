<?php

namespace Infrastructure\App\Interpreter\InterpreterPattern\Repository;

interface Invariant
{
    /**
     * @param type $id
     * @return Infrastructure\App\Interpreter\InterpreterPattern\Invariant
     */
    public function fetch($id);
}

