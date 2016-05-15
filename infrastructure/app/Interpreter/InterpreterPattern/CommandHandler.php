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
    
    private function interpret_statement($statement_ast)
    {
        if ($statement_ast->assert) {
            $this->interpret_assert($statement_ast->assert);
        }
        if ($statement_ast->apply) {
            $this->interpret_apply($statement_ast->apply);
        }
    }
    
    private function interpret_assert($ast)
    {
        if (!$this->check_invariant($ast)) {
            throw new InvariantException("Failure");
        }
    }
    
    //Hey
    private function check_invariant($ast)
    {
        $invariant = $this->fetch_invariant($ast->invariant_id);
        $arguments = $this->build_argument_list($ast->arguments);
        
        $result = $invariant->check($arguments);
        
        if ($ast->comparator == 'not') {
            return !$result;
        }
        
        return $result;
    }
    
    private function fetch_invariant($invariant_id)
    {
        return $this->invariant_repository->fetch($invariant_id);
    }
    
    private function build_argument_list($arguments_ast) 
    {
        $arguments = [];
        foreach ($arguments_ast as $argument_ast) {
            $arguments[] = $this->interpret_get_property($argument_ast->property);
        }
        return $arguments;
    }
    
    private function interpret_get_property($property_ast)
    {
        $property = $this->context;
        foreach ($property_ast as $key) {
            if (!isset($property->$key)) {
               throw new \Exception("Property '$key' does not exist"); 
            }
            $property = $property->$key;
        }
        return $property;
    }
             
    private function interpret_apply($ast)
    {
        $applied_event = $this->interpret_build_event($ast);
        
        $this->apply_event($applied_event);
        
        $this->applied_events[] = $applied_event;
    }
    
    private function interpret_build_event($ast)
    {
        $arguments = $this->build_argument_list($ast->arguments);
        
        $event = new \stdClass();
        $event->id = 'event_id';
        
        return $event;
    }
    
    private function apply_event($event)
    {
        
    }
}