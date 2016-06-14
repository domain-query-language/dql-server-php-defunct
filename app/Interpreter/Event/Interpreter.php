<?php namespace App\Interpreter\Event;

use App\Interpreter\Validation;

class Interpreter
{
    private $event_id;
    private $aggregate_id;
    private $validator;
    
    public function __construct($event_id, $aggregate_id, Validation\Validator $validator)
    {
        $this->event_id = $event_id;
        $this->aggregate_id = $aggregate_id;
        $this->validator = $validator;
    }
    
    public function interpret($root, $command)
    {  
        $result = (object)[
            "schema"=> (object)[
                'id'=>$this->event_id,
                'aggregate_id'=>$this->aggregate_id
            ],
            "domain"=> (object)[
                "aggregate_id"=>$root->id,
                'payload'=>$this->validator->validate($this->event_id, $command)
            ]
        ]; 
        
        return $result;
    }
}

