<?php

require_once "AbstractTest.php";
require_once "InvariantRepository/Fail.php";
require_once "InvariantRepository/Pass.php";

use Infrastructure\App\Interpreter\InterpreterPattern\CommandHandler;

class InterpreterPatternTest extends AbstractTest
{
    protected function build_fires_events_interpreter()
    {
        $invariant_repository = new Pass();
        return new CommandHandler($this->event_store, $invariant_repository, $this->ast->handler);
    }
    
    protected function build_fails_on_invariants_interpreter()
    {
        $invariant_repository = new Fail();
        return new CommandHandler($this->event_store, $invariant_repository, $this->ast->handler);
    }
}
