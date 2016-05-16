<?php namespace Infrastructure\App\Interpreter\InterpreterPattern;

use App\Interpreter\InvariantException;

class CommandHandler implements \App\Interpreter\Interpreter
{
    private $event_store;
    private $invariant_repository;
    private $ast;
    private $context;
    private $applied_events;
    
    public function __construct(
        \Infrastructure\Domain\EventStore $event_store,
        \App\Interpreter\InvariantRepository $invariant_repository,
        $ast
    )
    {
        $this->event_store = $event_store;
        $this->invariant_repository = $invariant_repository;
        $this->ast = $ast;
    }
        
    public function interpret($context)
    {
        $this->context = $context;
        foreach ($this->ast->statements as $statement_ast) {
            $this->interpret_statement($statement_ast);
        }
        
        return $this->applied_events;
    }
    
    private function interpret_statement($ast)
    {
        if ($ast->assert) {
            $this->interpret_assert($ast->assert);
        }
        if ($ast->apply) {
            $this->interpret_apply($ast->apply);
        }
    }
    
    private function interpret_assert($ast)
    {
        if (!$this->check_invariant($ast)) {
            throw new InvariantException("Failure");
        }
    }
    
    //Note: Internal function of invariants
    private function check_invariant($ast)
    {
        $invariant = $this->invariant_repository->fetch($ast->invariant_id);
        $arguments = $this->interpret_arguments($ast->arguments);
        
        $result = $invariant->check($arguments);
        
        if ($ast->comparator == 'not') {
            return !$result;
        }
        
        return $result;
    }
    
    private function interpret_arguments($ast) 
    {
        $arguments = [];
        foreach ($ast as $argument_ast) {
            $arguments[] = $this->interpret_get_property($argument_ast->property);
        }
        return $arguments;
    }
    
    private function interpret_get_property($ast)
    {
        $property = $this->context;
        foreach ($ast as $key) {
            if (!isset($property->$key)) {
               throw new \Exception("Property '$key' does not exist"); 
            }
            $property = $property->$key;
        }
        return $property;
    }
             
    private function interpret_apply($ast)
    {
        if (isset($ast->assert)) {
            if (!$this->check_invariant($ast->assert)) {
                return;
            }
        }
        
        $applied_event = $this->interpret_build_event($ast);
        
        $this->apply_event($applied_event);
    }
    
    private function interpret_build_event($ast)
    {
        $arguments = $this->interpret_arguments($ast->arguments);
        
        $event = new \stdClass();
        $event->id = 'event_id';
        
        return $event;
    }
    
    //Note: Private method of Aggregates
    private function apply_event($event)
    {
        $this->applied_events[] = $event;
    }
}