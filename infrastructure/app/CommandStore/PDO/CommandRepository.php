<?php namespace Infrastructure\App\CommandStore\PDO;

use PDO;
use App\CommandStore\Command;
use App\CommandStore\CommandBuilder;

class CommandRepository implements \App\CommandStore\CommandRepository
{
    private $pdo;
    private $builder;
    private $stream_select_statement;
    private $all_select_statement;
    
    public function __construct(PDO $pdo, CommandBuilder $builder)
    {
        $this->pdo = $pdo;
        $this->builder = $builder;
        
        $all_query = "
            SELECT 
                *
            FROM
                command_log
            ORDER BY 
                `order`
            LIMIT ?
            OFFSET ?
            ;
         ";
        
        $this->all_select_statement = $this->pdo->prepare($all_query);
    }
        
    public function fetch_all($offset, $limit)
    {
        $data = [$limit, $offset];
        
        $this->all_select_statement->execute($data);
        $rows = $this->all_select_statement->fetchAll(\PDO::FETCH_OBJ);
        
        return array_map(function($row){
            return $this->transform_row($row);
        }, $rows);
    }
    
    private function transform_row($row)
    {
        $this->builder->set_command_id($row->command_id) 
            ->set_occured_at($row->occured_at)
            ->set_schema_command_id($row->schema_command_id)
            ->set_schema_aggregate_id($row->schema_aggregate_id)
            ->set_aggregate_id($row->aggregate_id)
            ->set_payload(json_decode($row->payload));
            
        return $this->builder->build();
    }
        
    public function store(array $commands)
    {
        if (count($commands) == 0) {
            return;
        }
        $insert = "
            INSERT INTO command_log
                (command_id, aggregate_id, schema_command_id, schema_aggregate_id, occured_at, payload)
            VALUES";
        
        $values = [];
        $data = [];
        foreach ($commands as $command) {
            $values[] = "(?, ?, ?, ?, ?, ?)";
            $data = array_merge($data, $this->tranform_to_row($command));
        }
           
        $insert .= implode(",", $values);
                
        $this->pdo->prepare($insert)->execute($data);
    }
    
    private function tranform_to_row(Command $command)
    {
        return [
            $command->command_id,
            $command->aggregate_id,
            $command->schema->command_id,
            $command->schema->aggregate_id,
            $command->occured_at,
            json_encode($command->payload)
        ];
    }
}