<?php

class EventStore implements Infrastructure\Domain\EventStore {
            
    private $events = [];

    public function append(array $events) 
    {
        $this->events = $events;
    }

    public function events()
    {
        return $this->events;
    }
}

