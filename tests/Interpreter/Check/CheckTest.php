<?php namespace Test\Interpreter\Check;

use Infrastructure\App\Interpreter\Check;

class CheckTest extends \Test\Interpreter\TestCase
{   
    public function test_check_factory_handles_compare_ast()
    {
        $ast = $this->ast_repo->valueobject_simple();
        $factory = $this->app->make(Check\Factory::class);
        
        $this->assertInstanceOf(Check\Interpreter::class, $factory->ast($ast->check));
    }
    
    public function test_check_factory_handles_validator_ast()
    {
        $ast = $this->ast_repo->valueobject_validator();
        $factory = $this->app->make(Check\Factory::class);
        
        $this->assertInstanceOf(Check\Interpreter::class, $factory->ast($ast->check));
    }
}
