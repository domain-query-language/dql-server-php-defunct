<?php namespace Infrastructure\App\Interpreter\Aggregate;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $defaults;
    private $entity_interpreter;
    
    public function __construct($defaults, $entity_interpreter)
    {
        $this->defaults = $defaults;
        $this->entity_interpreter = $entity_interpreter;
    }
    
    public function interpret(Context $context)
    { 
        $entity_values = $this->defaults;
        $entity_values->id = $context->get_property('aggregate_id');
        $entity_context = new Context($entity_values);
        
        return $this->entity_interpreter->interpret($entity_context);
    }
}



