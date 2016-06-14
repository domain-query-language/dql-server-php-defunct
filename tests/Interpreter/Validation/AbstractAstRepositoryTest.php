<?php namespace Test\Interpreter\Validation;

use App\Interpreter\Validation;

abstract class AbstractAstRepositoryTest extends \Test\Interpreter\TestCase
{
    abstract protected function make_repository();    
    
    /** @var Validation\AstRepository */
    protected $repository;
    
    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->make_repository();
    }
    
    public function test_can_store_and_fetch_ast()
    {
        $ast = $this->ast_repo->valueobject_simple();
        
        $this->repository->store($ast);
        $actual = $this->repository->fetch($ast->id);
        
        $this->assertEquals($ast, $actual);
    }
    
    public function test_fails_if_cant_find_ast()
    {
        $unknown_id = "562bb0fe-c750-465f-b23a-83848f3440f3";
        
        $this->setExpectedException(Validation\Exception::class);
        
        $this->repository->fetch($unknown_id);
    }
}
