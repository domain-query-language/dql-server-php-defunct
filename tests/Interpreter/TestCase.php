<?php namespace Test\Interpreter;

class TestCase extends \Test\TestCase
{
    protected $ast_repo;
    
    public function setUp()
    {
        $this->ast_repo = new AstRepository();
        parent::setUp();
    }
}