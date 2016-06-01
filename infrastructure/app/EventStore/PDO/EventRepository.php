<?php namespace Infrastructure\App\EventStore\PDO;

use PDO;
use App\EventStore\Event;
use App\EventStore\EventBuilder;

class EventRepository
{
    private $pdo;
    private $select_statement;
    
    public function __construct(PDO $pdo, EventBuilder $event_builder)
    {
        $this->pdo = $pdo;
        $this->event_builder = $event_builder;
        
        $query = "
            SELECT 
                *
            FROM
                event_log
            WHERE
                aggregate_id = ?
                AND schema_aggregate_id = ?
            ORDER BY 
                `order`
            LIMIT ?
            OFFSET ?
            ;
         ";
        
        "   ";
                
        $this->select_statement = $this->pdo->prepare($query);
    }
    
    public function fetch(AggregateID $aggregate_id, $offset, $limit)
    {
        $domain_id = $aggregate_id->domain_id;
        $schema_id = $aggregate_id->schema_id;
        
        $data = [$domain_id, $schema_id, $limit, $offset];
        
        $this->select_statement->execute($data);
        $rows = $this->select_statement->fetchAll(\PDO::FETCH_OBJ);

        return array_map(function($event_row){
            $this->event_builder->set_id($event_row->event_id) 
                ->set_schema_id($event_row->schema_event_id)
                ->set_schema_aggregate_id($event_row->schema_aggregate_id)
                ->set_domain_aggregate_id($event_row->aggregate_id)
                ->set_domain_payload(json_decode($event_row->payload));
            
            return $this->event_builder->build();
        }, $rows);
    }
        
    public function store(array $events)
    {
        if (count($events) == 0) {
            return;
        }
        $insert = "
            INSERT INTO event_log
                (event_id, aggregate_id, schema_event_id, schema_aggregate_id, occured_at, payload)
            VALUES";
        
        $values = [];
        $data = [];
        foreach ($events as $event) {
            $values[] = "(?, ?, ?, ?, ?, ?)";
            $data += $this->make_pdo_data_from_event($event);
        }
           
        $insert .= implode(",", $values);
                
        $this->pdo->prepare($insert)->execute($data);
    }
    
    private function make_pdo_data_from_event(Event $event)
    {
        return [
            $event->id,
            $event->domain->aggregate_id,
            $event->schema->id,
            $event->schema->aggregate_id,
            $event->occured_at,
            json_encode($event->domain->payload)
        ];
    }
}