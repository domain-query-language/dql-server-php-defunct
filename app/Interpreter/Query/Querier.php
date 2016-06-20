<?php namespace App\Interpreter\Query;

use App\Interpreter\AstRepository;

class Querier 
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
    
    public function query($id, $root)
    {
        $ast = $this->repo->fetch($id);

        $querier = $this->factory->ast($ast);
        
        return $querier->query($root);
    }
}