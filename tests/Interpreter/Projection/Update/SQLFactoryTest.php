<?php namespace Test\Interpreter\Projection\Update;

use Infrastructure\App\Interpreter\Update\SQLFactory;

class SQLFactoryTest extends \Test\TestCase
{   
    public function test_convert_handler_ast_into_sql()
    {
        $ast = $this->load_json('tests/Interpreter/Projection/handler-ast.json');
        
        $factory = new SQLFactory();
        
        $sql = "UPDATE aggregate_5e867d81_9e3f_4a33_9150_6f4b373ba74f SET shopper_id =?";
        
        $this->assertEquals($sql, $factory->ast($ast));
    }
}