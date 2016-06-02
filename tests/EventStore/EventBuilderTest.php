<?php namespace Test\EventStore;

use App\EventStore\EventBuilder;
use App\EventStore\Event;
use App\EventStore\IDGenerator;
use App\EventStore\DateTimeGenerator;
use App\EventStore\Schema;
use App\EventStore\Domain;

class EventBuilderTest extends \Test\TestCase
{
    private $event_builder;
    private $event;
    
    public function setUp()
    {
        $stub_id_generator = $this->getMockBuilder(IDGenerator::class)->getMock();
        $stub_id_generator->method('generate')->willReturn("87484542-4a35-417e-8e95-5713b8f55c8e");
        
        $stub_datetime_generator = $this->getMockBuilder(DateTimeGenerator::class)->getMock();
        $stub_datetime_generator->method('generate')->willReturn('2014-10-10 12:12:12');
        
        $this->event_builder = new EventBuilder($stub_id_generator, $stub_datetime_generator);
        $this->event_builder->set_schema_id("14c3896d-092e-4370-bf72-2093facc9792")
            ->set_schema_aggregate_id("b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f")
            ->set_domain_aggregate_id("a955d32b-0130-463f-b3ef-23adec9af469")
            ->set_domain_payload((object)['value'=>true]);
        
        $this->event = $this->event_builder->build();
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
        $expected = new Schema();
        $expected->id = "14c3896d-092e-4370-bf72-2093facc9792";
        $expected->aggregate_id = "b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f";
      
        $this->assertEquals($expected, $this->event->schema);
    }
    
    public function test_populates_domain()
    {
        $expected = new Domain();
        $expected->aggregate_id = 'a955d32b-0130-463f-b3ef-23adec9af469';
        $expected->payload = (object)['value'=>true];
        
        $this->assertEquals($expected, $this->event->domain);
    }
    
    public function test_resets_after_build()
    {
        $event = $this->event_builder->build();
        
        $this->assertEquals(new Domain(), $event->domain);
        $this->assertEquals(new Schema(), $event->schema);
    }
    
    public function test_can_set_id()
    {
        $id = 'a7285082-a50c-4593-8b13-06a0fd75ba71';
        $this->event_builder->set_id($id);
        
        $event = $this->event_builder->build();
        $this->assertEquals($id, $event->id);
    }
}