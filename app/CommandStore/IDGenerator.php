<?php namespace App\CommandStore;

use Ramsey\Uuid\Uuid;

class IDGenerator
{
    public function generate()
    {
        return Uuid::uuid4()->toString();
    }
}


