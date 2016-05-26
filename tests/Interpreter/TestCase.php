<?php namespace Test\Interpreter;

class TestCase extends \Test\TestCase
{
    protected $ast_repo;
    
    public function setUp()
    {
        $this->ast_repo = new AstRepository();
        $this->app()->bind(\App\Interpreter\EventRepository::class, EventRepository::class);
        $this->app()->bind(\App\Interpreter\ValueObjectRepository::class, ValueObjectRepository::class);
        parent::setUp();
    }
}