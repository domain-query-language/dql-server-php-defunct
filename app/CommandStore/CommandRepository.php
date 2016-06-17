<?php namespace App\CommandStore;

interface CommandRepository
{
    public function fetch_all($offset, $limit);
    
    public function store(array $commands);
}
