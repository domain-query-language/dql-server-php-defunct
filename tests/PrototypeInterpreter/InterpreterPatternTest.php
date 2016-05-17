<?php

require_once "AbstractTest.php";
require_once "InvariantRepository/Fail.php";
require_once "InvariantRepository/Pass.php";

use Infrastructure\App\Interpreter\InterpreterPattern\CommandHandler;
use App\Interpreter\InvariantRepository;
use Infrastructure\App\Interpreter\InterpreterPattern\Handler;

class InterpreterPatternTest extends AbstractTest
{
    protected function build_fires_events_interpreter()
    {
        $this->app()->bind(InvariantRepository::class, Pass::class);
        $handler_factory = $this->app()->make(Handler\Factory::class);
        return new CommandHandler($handler_factory, $this->ast->handler);
    }
    
    protected function build_fails_on_invariants_interpreter()
    {
        $this->app()->bind(InvariantRepository::class, Fail::class);
        $handler_factory = $this->app()->make(Handler\Factory::class);
        return new CommandHandler($handler_factory, $this->ast->handler);
    }
}
