<?php

namespace Infrastructure\Domain;

interface EventStore
{
    public function append(array $events);
}