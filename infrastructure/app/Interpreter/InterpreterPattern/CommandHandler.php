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
        foreach ($this->ast->statements as $statement) {
            if ($statement->assert) {
                $this->assert($statement->assert);
            }
            if ($statement->apply) {
                $this->apply($statement->apply);
            }
        }
        
        return $this->applied_events;
    }
    
    private function assert($ast)
    {
        if (!$this->check_invariant($ast)) {
            throw new InvariantException("Failure");
        }
    }
    
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
            $arguments[] = $this->get_property($argument_ast->property);
        }
        return $arguments;
    }
    
    private function get_property($property_ast)
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
             
    private function apply($ast)
    {
        $applied_event = $this->build_event($ast);
        
        $this->apply_event($applied_event);
        
        $this->applied_events[] = $applied_event;
    }
    
    private function apply_event($event)
    {
        
    }
    
    private function build_event($ast)
    {
        $arguments = $this->build_argument_list($ast->arguments);
        
        $event = new \stdClass();
        $event->id = 'event_id';
        
        return $event;
    }
}