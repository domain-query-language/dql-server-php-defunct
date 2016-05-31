<?php namespace App\EventStore;

class Event
{
    public $id;
    public $occured_at;
    public $schema;
    public $domain;
}
