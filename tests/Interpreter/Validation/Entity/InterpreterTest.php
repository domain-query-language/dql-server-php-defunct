<?php namespace Test\Interpreter\Validation\Entity;

use App\Interpreter\Validation\Entity;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    public function setUp()
    {
        parent::setUp();
        $factory = $this->app->make(Entity\Factory::class);
        $this->interpreter = $factory->ast($this->ast_repo->entity());
    }
    
    public function test_ast_must_have_id_field()
    {
        $ast = $this->ast_repo->entity();
        unset($ast->children->id);
        $factory = $this->app->make(Entity\Factory::class);
        
        $this->setExpectedException(Entity\Exception::class);
        
        $factory->ast($ast);
    }
    
    public function test_build()
    {
        $data = [
            'id' => '7a53bbd2-8919-4bdf-a43c-c330b2f304e6',
            'quantity' => '5'
        ];
 
        $value = $this->interpreter->validate($data);
        
        $expected = ['id'=>'7a53bbd2-8919-4bdf-a43c-c330b2f304e6', 'quantity'=>5];
        
        $this->assertEquals((object)$expected, $value);
    }
}
