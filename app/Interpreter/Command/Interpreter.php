<?php namespace App\Interpreter\Command;

use App\Interpreter\Context;

class Interpreter
{
    private $command_id;
    private $aggregate_id;
    private $payload_interpreter;
    
    public function __construct($command_id, $aggregate_id, $payload_interpreter)
    {
        $this->command_id = $command_id;
        $this->aggregate_id = $aggregate_id;
        $this->payload_interpreter = $payload_interpreter;
    }
    
    public function interpret($value)
    {
        $key = 'payload';
        $payload = is_array($value) ? $value[$key] : $value->$key;
        
        $key = 'id';
        $id = is_array($value) ? $value[$key] : $value->$key;
        
        $result = (object)[
            "schema"=> (object)[
                'id'=>$this->command_id,
                'aggregate_id'=>$this->aggregate_id
            ],
            "domain"=> (object)[
                "aggregate_id"=> $id,
                'payload'=>$this->payload_interpreter->validate($payload)
            ]
        ]; 
        return $result;
    }
}

