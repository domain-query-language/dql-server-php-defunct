<?php namespace Test\CommandStore;

class CommandRepository implements \App\CommandStore\CommandRepository
{
    private $rows = [];
    
    public function set_row_count($row_count)
    {
        if ($row_count == 0) {
            return;
        }
        $this->rows = range(0, $row_count-1);
    }
    
    public function fetch_all($offset, $limit)
    {
        return array_slice($this->rows, $offset, $limit);
    }

    public function store(array $commands)
    {
        
    }
}