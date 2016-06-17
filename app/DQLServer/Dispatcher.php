<?php namespace App\DQLServer;

interface Dispatcher 
{
    public function dispatch(Command $command);
}