<?php namespace App\Interpreter\Command;

use App\Interpreter\Validation;

class Interpreter
{
    private $command_id;
    private $aggregate_id;
    private $validator;
    
    public function __construct($command_id, $aggregate_id, Validation\Validator $validator)
    {
        $this->command_id = $command_id;
        $this->aggregate_id = $aggregate_id;
        $this->validator = $validator;
    }
    
    public function interpret($value)
    {
        $aggregate_id = $value->id;
        $payload = isset($value->payload) ? $value->payload: [];
        
        $result = (object)[
            "schema"=> (object)[
                'id'=>$this->command_id,
                'aggregate_id'=>$this->aggregate_id
            ],
            "domain"=> (object)[
                "aggregate_id"=> $aggregate_id,
                'payload'=>$this->validator->validate($this->command_id, $payload)
            ]
        ]; 
        return $result;
    }
}

