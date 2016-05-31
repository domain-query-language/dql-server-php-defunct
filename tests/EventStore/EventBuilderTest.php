<?php namespace Test\EventStore;

use App\EventStore\EventBuilder;
use App\EventStore\Event;

class EventBuilderTest extends \Test\TestCase
{
    private $event;
    
    public function setUp()
    {
        $event_builder = new EventBuilder(new IDGenerator());
        $event_builder->set_schema_id("14c3896d-092e-4370-bf72-2093facc9792");
        $event_builder->set_schema_aggregate_id("b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f");
        $event_builder->set_domain_aggregate_id("a955d32b-0130-463f-b3ef-23adec9af469");
        $event_builder->set_domain_payload((object)['value'=>true]);
        
        $this->event = $event_builder->build();
    }
    
    public function test_builds_class()
    {
        $this->assertInstanceOf(Event::class, $this->event);
    }
    
    public function test_gives_event_id()
    {
        $this->assertEquals("87484542-4a35-417e-8e95-5713b8f55c8e", $this->event->id);
    }
    
    public function test_gives_occured_at()
    {
        $this->assertEquals("2014-10-10 12:12:12", $this->event->occured_at);
    }
    
    public function test_populates_schema()
    {
        $expected = (object)[
            "id" => "14c3896d-092e-4370-bf72-2093facc9792",
            "aggregate_id" => "b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f"
        ];
        
        $this->assertEquals($expected, $this->event->schema);
    }
    
    public function test_populates_domain()
    {
        $expected = (object)[
            'aggregate_id' => 'a955d32b-0130-463f-b3ef-23adec9af469',
            'payload' => (object)['value'=>true]
        ];
        
        $this->assertEquals($expected, $this->event->domain);
    }
}