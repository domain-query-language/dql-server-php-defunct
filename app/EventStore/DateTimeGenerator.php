<?php namespace App\EventStore;

use Carbon\Carbon;

class DateTimeGenerator
{
    public function generate()
    {
        return Carbon::now()->toDateTimeString();
    }
}