<?php namespace Test\Interpreter\Projection;

use App\Interpreter\InvariantRepository;
use App\Interpreter\Context;
use App\Interpreter\InvariantException;
use Infrastructure\App\Interpreter\Update;
use Infrastructure\App\Interpreter\Query;

class InterpreterTest extends \Test\TestCase
{
    protected $ast;
    
    public function setUp()
    {
        //$this->ast = $this->ast();
    }
    
    public function test_query_returns_false_initially()
    {
        //$query_factory = $this->app()->make(Handler\Query::class);
    }
    
    public function test_update_sets_the_value()
    {
        //$update_factory = $this->app()->make(Handler\Update::class);
    }
    
    public function test_query_returns_false_for_different_shopper_id()
    {
        
    }  
}
