<?php namespace App\Interpreter\Modification;

use App\Interpreter\AstRepository;

class Modifier 
{
    private $repo;
    private $modifier_factory;
    
    public function __construct(AstRepository $repo, Factory $modifier_factory)
    {
        $this->repo = $repo;
        $this->modifier_factory = $modifier_factory;
    }
    
    public function create($ast)
    {
        $this->repo->store($ast);
    }
    
    public function modify($id, $mutable, $datasource)
    {
        $ast = $this->repo->fetch($id);

        $modifier = $this->modifier_factory->ast($ast);
        
        return $modifier->modify($mutable, $datasource);
    }
}