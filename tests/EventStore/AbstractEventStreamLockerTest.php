<?php namespace Test\EventStore;

use Test\DBTestCase;
use App\EventStore\StreamID;
use App\EventStore\EventStreamLockerException;
use App\EventStore\DateTimeGenerator;

abstract class AbstractEventStreamLockerTest extends DBTestCase
{
    protected $locker;
    protected $stream_id;
    protected $stub_datetime_generator;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->stub_datetime_generator = $this->getMockBuilder(DateTimeGenerator::class)->getMock();
        $this->stub_datetime_generator->method('generate')->willReturn('2014-10-10 00:00:00.000');
        
        $this->locker = $this->make_locker($this->stub_datetime_generator);
        
        $this->stream_id = new StreamID(
            "b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f",
            "a955d32b-0130-463f-b3ef-23adec9af469"  
        );
        
        $this->locker->unlock($this->stream_id);
    }
    
    abstract protected function make_locker(DateTimeGenerator $stub_datetime_generator);
    
    public function test_locking_a_stream_prevents_others_from_accessing_it()
    {
        $this->locker->lock($this->stream_id);
        
        $this->setExpectedException(EventStreamLockerException::class);
        
        $this->locker->lock($this->stream_id);
    }
    
    public function test_unlocking_a_stream_allows_access()
    {
        $this->locker->lock($this->stream_id);
        $this->locker->unlock($this->stream_id);
        
        $this->locker->lock($this->stream_id);
        $this->locker->unlock($this->stream_id);
    }
    
    public function test_locks_are_only_for_the_stream_id()
    {
        $this->locker->lock($this->stream_id);
        
        $different_stream_id = new StreamID(
            "e974e9d5-865f-4e0c-9fb0-df1812eceaf7",
            "49914cfe-4e96-4c07-bba3-ac96ef7d4259"
        );
        $this->locker->lock($different_stream_id);
        
        $this->locker->unlock($different_stream_id);
    }
    
    public function test_locks_unlock_after_500ms()
    {
        $stub_datetime_generator = $this->getMockBuilder(DateTimeGenerator::class)->getMock();
        $stub_datetime_generator->method('generate')
            ->will($this->onConsecutiveCalls(
                '2014-10-10 00:00:00.000', 
                '2014-10-10 00:00:00.500'
            ));
        
        $locker = $this->make_locker($stub_datetime_generator);
        
        $locker->lock($this->stream_id);
        
        $locker->lock($this->stream_id);
    }
    
    public function test_does_not_unlock_before_500ms()
    {
        $this->setExpectedException(EventStreamLockerException::class);
        
        $stub_datetime_generator = $this->getMockBuilder(DateTimeGenerator::class)->getMock();
        $stub_datetime_generator->method('generate')
            ->will($this->onConsecutiveCalls(
                '2014-10-10 00:00:00.000', 
                '2014-10-10 00:00:00.499'
            ));
        
        $locker = $this->make_locker($stub_datetime_generator);
        
        $locker->lock($this->stream_id);
        
        $locker->lock($this->stream_id);
    }
}