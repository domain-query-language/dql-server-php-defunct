<?php namespace Test\Interpreter\Assert;

use Infrastructure\App\Interpreter\Invariant\ParameterScanner;

class ParameterScannerTest extends \Test\Interpreter\TestCase
{
     public function test_scanning_in_aggregate_invariant_no_arguments()
    {
        $ast = $this->ast_repo->invariant();
        $scanner = new ParameterScanner();
        $expected_parameters = [];
        
        $this->assertEquals($expected_parameters, $scanner->scan($ast));
    }
    
    public function test_scanning_in_aggregate_invariant()
    {
        $ast = $this->ast_repo->invariant_arguments();
        $scanner = new ParameterScanner();
        $expected_parameters = ['shopper_id', 'is_created'];
        
        $this->assertEquals($expected_parameters, $scanner->scan($ast));
    }
    
    public function test_scanning_projection_invariant()
    {
        $ast = $this->ast_repo->invariant_projection();
        $scanner = new ParameterScanner();
        $expected_parameters = ['shopper_id', 'is_created'];
        
        $this->assertEquals($expected_parameters, $scanner->scan($ast));
    }
}
    