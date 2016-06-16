<?php namespace App\Interpreter\Validation;

class Validator 
{
    private $repo;
    private $vo_factory;
    
    public function __construct(AstRepository $repo, ValueObject\Factory $vo_factory)
    {
        $this->repo = $repo;
        $this->vo_factory = $vo_factory;
    }
    
    public function create($ast)
    {
        $ast = (object)$ast;
        if (!isset($ast->id)){
            throw new Exception("Ast is not valid");
        }
        if (!isset($ast->check) && !isset($ast->children)){
            throw new Exception("Ast is not valid");
        }
        $this->repo->store($ast);
    }
    
    public function validate($id, $value)
    {
        $ast = $this->repo->fetch($id);
        
        $validator = $this->vo_factory->ast($ast);
        
        return $validator->validate($value);
    }
    
    public function check($id, $value, $arguments=null)
    {
        $ast = $this->repo->fetch($id);
        
        $validator = $this->vo_factory->ast($ast);
        
        if ($arguments) {
            return $validator->check($value, $arguments);
        }
        return $validator->check($value);
    }
}