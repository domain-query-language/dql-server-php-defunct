<?php namespace App\Interpreter\Command;

use App\Interpreter\Validation;
use App\DQLServer\Command;

class Interpreter
{
    private $validator;
    private $ast_repo;
    
    public function __construct(
        Validation\Validator $validator,
        AstRepository $ast_repo
    )
    {
        $this->validator = $validator;
        $this->ast_repo = $ast_repo;
    }
    
    public function transform(Command $command)
    {
        $payload = isset($command->payload) ? $command->payload: [];
        
        $ast = $this->ast_repo->fetch($command->command_id);
        
        $result = (object)[
            "schema"=> (object)[
                'id'=>$command->command_id,
                'aggregate_id'=>$ast->aggregate_id
            ],
            "domain"=> (object)[
                "aggregate_id"=> $command->aggregate_id,
                'payload'=>$this->validator->validate($command->command_id, $payload)
            ]
        ]; 
        return $result;
    }
}

