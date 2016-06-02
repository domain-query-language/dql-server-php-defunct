<?php namespace Test\EventStore;

use Test\DBTestCase;
use App\EventStore\EventBuilder;
use App\EventStore\StreamID;
use App\EventStore\EventRepository;
use App\EventStore\EventRepositoryException;

abstract class AbstractEventRepositoryTest extends DBTestCase
{
    protected $event_builder;
    protected $event;
    protected $repo;
    protected $stream_id;
    
    public function setUp()
    {
        parent::setUp();
        
        /** @var EventBuilder */
        $this->event_builder = $this->app->make(EventBuilder::class);
        $this->event_builder->set_id("c91942f1-3c94-4900-a3b0-4497311e3503")
            ->set_schema_id("14c3896d-092e-4370-bf72-2093facc9792")
            ->set_domain_aggregate_id("a955d32b-0130-463f-b3ef-23adec9af469")
            ->set_schema_aggregate_id("b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f")
            ->set_occured_at("2014-10-10 12:12:12")
            ->set_domain_payload((object)['value'=>true]);
        
        $this->event = $this->event_builder->build();
        
        $this->repo = $this->build_event_repository();
        
        $this->repo->store([$this->event]);
        
        $this->stream_id = new StreamID(
            "b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f",
            "a955d32b-0130-463f-b3ef-23adec9af469"  
        );
        
        $this->repo->unlock($this->stream_id);
    }
    
    /** @return EventRepository */
    abstract protected function build_event_repository();
    
    public function test_fetch()
    {
        $results = $this->repo->fetch($this->stream_id, 0, 10);
        
        $this->assertEquals([$this->event], $results);
    }
    
    public function test_returns_empty_if_no_results()
    {
        $stream_id = new StreamID(
            "b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f",
            "03ad4280-01f3-450b-8e0a-55c1365e40ee"  
        );
                
        $results = $this->repo->fetch($stream_id, 0, 10);
        
        $this->assertEquals([], $results);
    }
}