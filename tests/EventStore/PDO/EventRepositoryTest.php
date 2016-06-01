<?php namespace Test\EventStore\PDO;

use Test\DBTestCase;
use Infrastructure\App\EventStore\PDO\EventRepository;
use App\EventStore\EventBuilder;
use Infrastructure\App\EventStore\PDO\AggregateID;

class EventRepositoryTest extends DBTestCase
{
    private $event;
    private $repo;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->artisan('migrate');
        
        /** @var EventBuilder */
        $event_builder = $this->app->make(EventBuilder::class);
        $event_builder->set_id("c91942f1-3c94-4900-a3b0-4497311e3503")
            ->set_schema_id("14c3896d-092e-4370-bf72-2093facc9792")
            ->set_domain_aggregate_id("a955d32b-0130-463f-b3ef-23adec9af469")
            ->set_schema_aggregate_id("b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f")
            ->set_domain_payload((object)['value'=>true]);
        
        $this->event = $event_builder->build();
        
        $this->repo = new EventRepository(self::$pdo, $event_builder);
    }
    
    public function test_fetch()
    {
        $aggregate_id = new AggregateID(
            "b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f",
            "a955d32b-0130-463f-b3ef-23adec9af469"  
        );
        
        $this->repo->store([$this->event]);
        
        $results = $this->repo->fetch($aggregate_id, 0, 10);
        
        $this->assertEquals([$this->event], $results);
    }
}