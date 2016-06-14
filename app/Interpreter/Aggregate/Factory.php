<?php namespace App\Interpreter\Aggregate;

use App\Interpreter\Validation;
use App\Interpreter\Modification;
use Test\Interpreter\EventStore;

class Factory
{    
    private $validator;
    private $modification;
    private $event_store;
 
    public function __construct(
        Validation\Validator $validator,
        Modification\Modifier $modification,
        EventStore $event_store
    )
    {
        $this->validator = $validator;
        $this->modification = $modification;
        $this->event_store = $event_store;
    }
    
    public function ast($ast)
    {
        return new Interpreter(
            $ast,
            $this->validator,
            $this->modification,
            $this->event_store
        );
    }
}



