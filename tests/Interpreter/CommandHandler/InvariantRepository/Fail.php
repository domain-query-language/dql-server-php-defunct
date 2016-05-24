<?php namespace Test\Interpreter\CommandHandler\InvariantRepository;

class Fail extends Pass
{
    public function fetch_ast($id)
    {
        $ast = parent::fetch_ast($id);
        $ast->check->condition->comparator = "!=";
        return $ast;
    }
}