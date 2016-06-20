<?php namespace Test\Interpreter\Validation;

use App\Interpreter\Validation;
use App\Interpreter\AstRepository;

class ValidatorTest extends \Test\Interpreter\TestCase
{    
    private $validator_repo;
    private $vo_factory;
    private $validator;
    
    public function setUp()
    {
        parent::setUp();
        $this->validator_repo = $this->mock(AstRepository::class);
        $this->vo_factory = $this->mock(Validation\ValueObject\Factory::class);

        $this->validator = new Validation\Validator(
            $this->validator_repo->reveal(), 
            $this->vo_factory->reveal()
        );
    }
    
    public function test_validator_stores_validators()
    {
        $ast = $this->fake_ast_repo->valueobject_boolean();
        $this->validator_repo->store($ast)->shouldBeCalled();
        
        $this->validator->create($ast);
    }
    
    public function test_validator_fails_if_given_invalid_validator()
    {
        $ast_with_no_check_or_children = [
            'id' => '1b12d9b6-0c27-432f-b14d-733c49a1da23'
        ];
        
        $this->setExpectedException(Validation\Exception::class);
        
        $this->validator->create($ast_with_no_check_or_children);
    }
    
    public function test_validator_calls_validate_and_returns_result()
    {
        $id = "f00c202c-13b7-4bd4-b619-7f0a98947e98";
        
        $expected = ['data'=>true];
        
        $ast = 'asdf';

        $mock_validator = $this->mock(Validation\ValueObject\SimpleInterpreter::class);

        $mock_validator->validate($expected)
            ->shouldBeCalled()->willReturn($expected);
        
        $this->vo_factory->ast($ast)
            ->shouldBeCalled()->willReturn($mock_validator->reveal());
    
        $this->validator_repo->fetch($id)
            ->shouldBeCalled()->willReturn($ast);

        $actual = $this->validator->validate($id, $expected);
        
        $this->assertEquals($expected, $actual);
    }
    
    private function setup_dependencies($id, $ast, $mock_validator)
    {
        $this->vo_factory->ast($ast)
            ->shouldBeCalled()->willReturn($mock_validator->reveal());
    
        $this->validator_repo->fetch($id)
            ->shouldBeCalled()->willReturn($ast);
    }
    
    private function mock_check($expected)
    {
        $mock_validator = $this->mock(Validation\ValueObject\SimpleInterpreter::class);
        
        $mock_validator->check($expected)
            ->shouldBeCalled()
            ->willReturn(true);
        
        return $mock_validator;
    }
    
    public function test_validator_can_check_if_passes_validation()
    {
        $id = "f00c202c-13b7-4bd4-b619-7f0a98947e98";
        $expected = ['data'=>true];
        $ast = 'asdf';

        $mock_validator = $this->mock_check($expected);
        $this->setup_dependencies($id, $ast, $mock_validator);

        $this->assertTrue($this->validator->check($id, $expected));
    }
    
    private function mock_check_with_arguments($expected, $arguments)
    {
        $mock_validator = $this->mock(Validation\ValueObject\SimpleInterpreter::class);
        
        $mock_validator->check($expected, $arguments)
            ->shouldBeCalled()->willReturn(true);
        
        return $mock_validator;
    }
    
    public function test_validator_also_accepts_arguments()
    {
        $id = "f00c202c-13b7-4bd4-b619-7f0a98947e98";
        $expected = ['data'=>true];
        $ast = 'asdf';
        $arguments = ['args!'];

        $mock_validator = $this->mock_check_with_arguments($expected, $arguments);
        $this->setup_dependencies($id, $ast, $mock_validator);

        $this->assertTrue($this->validator->check($id, $expected, $arguments));   
    }
} 