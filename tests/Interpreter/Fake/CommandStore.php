<?php namespace Test\Interpreter\Fake;

class CommandStore implements \App\Interpreter\CommandStore
{
    private static $commands = [];
    
    public function fetch_all()
    {
        return self::$commands;
    }
    
    public function store(array $commands)
    {
        self::$commands = $commands;
    }
}
