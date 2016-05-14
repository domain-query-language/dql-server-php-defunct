<?php

namespace Infrastructure\App\Interpreter\InterpreterPattern;

class CommandHandler implements App\Interpreter\Interpreter
{
    private $event_store;
    private $statements;
    private $applied_events;
    
    public function __construct(\Infrastructure\Domain\EventStore $event_store)
    {
        $this->event_store = $event_store;
    }
    
    public function add_statement(Statement $statement)
    {
        $this->statements[] = $statement;
    }
    
    public function interpret($context)
    {
        foreach ($this->statements as $statement) {
            if ($statement->assert) {
                $this->assert($statement->assert);
            }
            if ($statement->apply) {
                $this->apply($statement->apply);
            }
            $statement->interpret($context);
        }
    }
    
    private function assert(Invariant $invariant, $context)
    {
        $invariant->interpret($context);
    }
    
    private function apply(Event $event, $context)
    {
        $applied_event = $event->intrepert($context);
        if ($applied_event) {
            $this->applied_events[] = $applied_event;
        }
    }
}