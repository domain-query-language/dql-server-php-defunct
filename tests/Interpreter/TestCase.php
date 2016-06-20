<?php namespace Test\Interpreter;

class TestCase extends \Test\TestCase
{
    protected $fake_ast_repo;
    
    public function setUp()
    {
        parent::setUp();
             
        $this->fake_ast_repo = new Fake\AstRepository();
        $this->app->bind(\PDO::class, Fake\PDO::class);
        $this->app->bind(\App\Interpreter\AstRepository::class, Fake\AstRepository::class);     
        $this->app->bind(\App\Interpreter\EventStore::class, Fake\EventStore::class);
        $this->app->bind(\App\Interpreter\CommandStore::class, Fake\CommandStore::class);
    }
}