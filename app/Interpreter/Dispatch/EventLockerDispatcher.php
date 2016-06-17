<?php namespace App\Interpreter\Dispatch;

use App\EventStore\EventStreamLocker;
use App\EventStore\StreamID;
use App\Interpreter\Dispatch;

class EventLockerDispatcher
{
    private $event_stream_locker;
    private $dispatcher;
    
    public function __construct(
        EventStreamLocker $event_stream_locker,
        Dispatch\Dispatcher $dispatcher
    ){
        $this->event_stream_locker = $event_stream_locker;
        $this->dispatcher = $dispatcher;
    }
    
    public function dispatch($command)
    {
        $schema_id = $command->schema->aggregate_id;
        $domain_id = $command->domain->aggregate_id;
        
        $stream_id = new StreamID($schema_id, $domain_id);
        try {
            $this->event_stream_locker->lock($stream_id);
            $events = $this->dispatcher->dispatch($command);
            $this->event_stream_locker->unlock($stream_id);
            return $events;
        } catch (\Exception $ex) {
            $this->event_stream_locker->unlock($stream_id);
            throw $ex;
        }
        
    }
}

