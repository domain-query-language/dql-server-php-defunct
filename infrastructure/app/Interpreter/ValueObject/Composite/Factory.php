<?php namespace Infrastructure\App\Interpreter\ValueObject\Composite;

class Factory 
{    
    private $value_object_repo;
    
    public function __construct(\App\Interpreter\ValueObjectRepository $repo)
    {
        $this->value_object_repo = $repo;
    }
    
    public function ast($ast, \Infrastructure\App\Interpreter\ValueObject\Factory $vo_factory)
    {
        $interpreters = [];
        foreach ($ast as $vo_id) {
            $vo_ast = $this->value_object_repo->fetch_ast($vo_id);
            $interpreters[] = $vo_factory->ast($vo_ast);
        }
        
        return new Interpreter($interpreters, array_keys((array)$ast));
    }
}

