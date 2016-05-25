<?php namespace Infrastructure\App\Interpreter\Entity;

class Factory 
{    
    private $value_object_repo;
    private $value_object_factory;
    
    public function __construct(
        \App\Interpreter\ValueObjectRepository $repo,
        \Infrastructure\App\Interpreter\ValueObject\Factory $vo_factory)
    {
        $this->value_object_repo = $repo;
        $this->value_object_factory = $vo_factory;
    }
    
    public function ast($ast)
    {
        if (!isset($ast->children->id)) {
            throw new Exception("Entities must have an ID");
        }
        $interpreters = [];
        foreach ($ast->children as $vo_id) {
            $vo_ast = $this->value_object_repo->fetch_ast($vo_id);
            $interpreters[] = $this->value_object_factory->ast($vo_ast);
        }
        
        return new Interpreter($interpreters, array_keys((array)$ast->children));
    }
}

