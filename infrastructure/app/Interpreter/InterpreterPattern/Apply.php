<?php namespace Infrastructure\App\Interpreter\InterpreterPattern;

use App\Interpreter\InvariantRepository;
use App\Interpreter\Context;

class Apply
{    
    private $check_interpreter;
    private $arguments_interpreter;
    
    public function __construct($ast, InvariantRepository $invariant_repo)
    {
        if (isset($ast->assert)) {
            $this->check_interpreter = new Check($ast->assert, $invariant_repo);
        } else {
            $this->check_interpreter = new NullInterpreter();
        }
        
        $this->arguments_interpreter = new Arguments($ast->arguments);
    }
    
    public function interpret(Context $context)
    {
        if (!$this->check_interpreter->interpret($context)) {
           return; 
        }
        
        $arguments = $this->arguments_interpreter->interpret($context);
        
        $event = new \stdClass();
        $event->id = 'event_id';
        
        return $event;
    }
}


