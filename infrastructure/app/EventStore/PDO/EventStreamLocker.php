<?php namespace Infrastructure\App\EventStore\PDO;

use App\EventStore\StreamID;
use PDO;

class EventStreamLocker implements \App\EventStore\EventStreamLocker
{
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function lock(StreamID $stream_id)
    {
        $key = $stream_id->domain_id.",".$stream_id->schema_id;
        
        $insert = "
            INSERT INTO event_stream_lock
                (stream_id)
            VALUES
                (?)";
        
        try {
            $this->pdo->prepare($insert)->execute([$key]);
        } catch (\PDOException $ex) {
            throw new \App\EventStore\EventStreamLockerException();
        }
    }
    
    public function unlock(StreamID $stream_id)
    {
        $key = $stream_id->domain_id.",".$stream_id->schema_id;
        
        $delete = "
            DELETE FROM event_stream_lock
            WHERE stream_id =?";
        
        $this->pdo->prepare($delete)->execute([$key]);
    }
}