<?php namespace Test\Interpreter;

use Test\Interpreter\Fake\AstRepository;

class TestCase extends \Test\TestCase
{
    protected $ast_repo;
    
    public function setUp()
    {
        parent::setUp();
             
        $this->ast_repo = new AstRepository();
        $this->app->bind(\PDO::class, Projection\MockPDO::class);
        $this->app->bind(\App\Interpreter\AstRepository::class, AstRepository::class);     
        $this->app->bind(\App\Interpreter\EventStore::class, Fake\EventStore::class);
        $this->app->bind(\App\Interpreter\CommandStore::class, Fake\CommandStore::class);
    }
}