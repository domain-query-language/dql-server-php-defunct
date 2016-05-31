<?php namespace Test\EventStore;

class IDGenerator implements \App\EventStore\IDGenerator
{
    public function generate()
    {
        return "87484542-4a35-417e-8e95-5713b8f55c8e";
    }
}