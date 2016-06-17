<?php namespace App\CommandStore;

class FullCommandStream extends AbstractCommandStream
{
    protected function get_next_chunk($offset, $limit)
    {
        return $this->repo->fetch_all($offset, $limit);
    }
}