<?php namespace App\Interpreter\Handler;

use App\Interpreter\AstRepository;

class Handler 
{
    private $repo;
    private $factory;
    
    public function __construct(AstRepository $repo, Factory $factory)
    {
        $this->repo = $repo;
        $this->factory = $factory;
    }
    
    public function create($ast)
    {
        $this->repo->store($ast);
    }
    
    public function handle($id, $root_entity, $command_payload)
    {
        $ast = $this->repo->fetch($id);
        $handler = $this->factory->ast($ast);
        return $handler->handle($root_entity, $command_payload);
    }
}