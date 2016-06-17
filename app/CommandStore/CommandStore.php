<?php namespace App\CommandStore;

class CommandStore
{
    private $repository;
    private $stream_factory;
    
    public function __construct(
        CommandRepository $repository,
        CommandStreamFactory $stream_factory
    )
    {
        $this->repository = $repository;
        $this->stream_factory = $stream_factory;
    }
    
    public function store(array $commands)
    {
        $this->repository->store($commands);
    }

    public function all()
    {
        return $this->stream_factory->all();
    }
}