<?php namespace Test\Interpreter\Validation\Check;

use App\Interpreter\Validation\Checker;

class CheckTest extends \Test\Interpreter\TestCase
{   
    public function test_check_factory_handles_compare_ast()
    {
        $ast = $this->ast_repo->valueobject_simple();
        $factory = $this->app->make(Checker\Factory::class);
        
        $this->assertInstanceOf(Checker\Interpreter::class, $factory->ast($ast->check));
    }
    
    public function test_check_factory_handles_validator_ast()
    {
        $ast = $this->ast_repo->valueobject_validator();
        $factory = $this->app->make(Checker\Factory::class);
        
        $this->assertInstanceOf(Checker\Interpreter::class, $factory->ast($ast->check));
    }
}
