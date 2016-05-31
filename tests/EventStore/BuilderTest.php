<?php namespace Test\EventStore;

use App\EventStore\Builder;
use App\EventStore\Event;
use App\EventStore\IDGenerator;
use App\EventStore\Schema;
use App\EventStore\Domain;

class BuilderTest extends \Test\TestCase
{
    private $event;
    
    public function setUp()
    {
        $stub_generator = $this->getMockBuilder(IDGenerator::class)->getMock();
        $stub_generator->method('generate')->willReturn("87484542-4a35-417e-8e95-5713b8f55c8e");
        
        $event_builder = new Builder($stub_generator);
        $event_builder->set_schema_id("14c3896d-092e-4370-bf72-2093facc9792")
            ->set_schema_aggregate_id("b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f")
            ->set_domain_aggregate_id("a955d32b-0130-463f-b3ef-23adec9af469")
            ->set_domain_payload((object)['value'=>true]);
        
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
}