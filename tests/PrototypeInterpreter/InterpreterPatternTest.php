<?php

require_once "AbstractTest.php";

class InterpreterPatternTest extends AbstractTest
{
    protected function build_fails_on_invariants_interpreter()
    {
        $interpreter = new Interpreter();
    }

    protected function build_fires_events_interpreter()
    {
        
    }
}
