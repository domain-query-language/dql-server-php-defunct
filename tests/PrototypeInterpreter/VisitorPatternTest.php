<?php

require_once "AbstractTest.php";
require_once "InvariantRepository/Fail.php";
require_once "InvariantRepository/Pass.php";

use Infrastructure\App\Interpreter\VisitorPattern\CommandHandler;

class VisitorPatternTest extends AbstractTest
{
    protected function build_fires_events_interpreter()
    {
        $invariant_repository = new Pass(\Infrastructure\App\Interpreter\VisitorPattern\AST\Invariant::class);
        return new CommandHandler($invariant_repository, $this->ast->handler);
    }
    
    protected function build_fails_on_invariants_interpreter()
    {
        $invariant_repository = new Fail(\Infrastructure\App\Interpreter\VisitorPattern\AST\Invariant::class);
        return new CommandHandler($invariant_repository, $this->ast->handler);
    }
}
