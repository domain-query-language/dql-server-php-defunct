<?php namespace Infrastructure\App\EventStore\PDO;

use PDO;
use App\EventStore\Event;
use App\EventStore\EventBuilder;
use App\EventStore\StreamID;

class EventRepository implements \App\EventStore\EventRepository
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
    
    public function fetch(StreamID $aggregate_id, $offset, $limit)
    {
        $domain_id = $aggregate_id->domain_id;
        $schema_id = $aggregate_id->schema_id;
        
        $data = [$domain_id, $schema_id, $limit, $offset];
        
        $this->select_statement->execute($data);
        $rows = $this->select_statement->fetchAll(\PDO::FETCH_OBJ);

        return array_map(function($event_row){
            $this->event_builder->set_event_id($event_row->event_id) 
                ->set_occured_at($event_row->occured_at)
                ->set_schema_event_id($event_row->schema_event_id)
                ->set_schema_aggregate_id($event_row->schema_aggregate_id)
                ->set_aggregate_id($event_row->aggregate_id)
                ->set_payload(json_decode($event_row->payload));
            
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
            $event->event_id,
            $event->aggregate_id,
            $event->schema->event_id,
            $event->schema->aggregate_id,
            $event->occured_at,
            json_encode($event->payload)
        ];
    }
    
    private static $locks = [];
    
    public function lock(StreamID $stream_id)
    {
        $key = $stream_id->domain_id.",".$stream_id->schema_id;
        
        if (isset(self::$locks[$key])) {
            throw new \App\EventStore\EventRepositoryException();
        }
        self::$locks[$key] = true;
    }
    
    public function unlock(StreamID $stream_id)
    {
        $key = $stream_id->domain_id.",".$stream_id->schema_id;
        self::$locks[$key] = null;
    }
}