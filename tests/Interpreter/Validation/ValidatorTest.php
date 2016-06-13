<?php namespace Test\Interpreter\Validation;

use App\Interpreter\Validation;

class ValidatorTest extends \Test\Interpreter\TestCase
{    
    private $validator_repo;
    private $vo_factory;
    private $validator;
    
    public function setUp()
    {
        parent::setUp();
        $this->validator_repo = 
                $this->getMockBuilder(Validation\AstRepository::class)->getMock();
        
        $vo_factory_class = Validation\ValueObject\Factory::class;
        $this->vo_factory = $this->getMockBuilder($vo_factory_class)
            ->disableOriginalConstructor()->getMock();

        $this->validator = new Validation\Validator($this->validator_repo, $this->vo_factory);
    }
    
    public function test_validator_stores_validators()
    {
        $ast = $this->ast_repo->valueobject_boolean();
        $this->validator_repo->expects($this->once())
            ->method('store')
            ->with($ast);
        
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

        $simple_vo_class = Validation\ValueObject\SimpleInterpreter::class;
        $mock_validator = $this->getMockBuilder($simple_vo_class)
            ->disableOriginalConstructor()->getMock();
        
        $mock_validator->expects($this->once())
            ->method('validate')
            ->with($expected)
            ->willReturn($expected);
        
        $this->vo_factory->expects($this->once())
            ->method('ast')
            ->with($ast)
            ->willReturn($mock_validator);
    
        $this->validator_repo->expects($this->once())
            ->method('fetch')
            ->with($id)
            ->willReturn($ast);

        $actual = $this->validator->validate($id, $expected);
        
        $this->assertEquals($expected, $actual);
    }
    
    public function test_validator_can_check_if_passes_validation()
    {
        $id = "f00c202c-13b7-4bd4-b619-7f0a98947e98";
        
        $expected = ['data'=>true];
        
        $ast = 'asdf';

        $simple_vo_class = Validation\ValueObject\SimpleInterpreter::class;
        $mock_validator = $this->getMockBuilder($simple_vo_class)
            ->disableOriginalConstructor()->getMock();
        
        $mock_validator->expects($this->once())
            ->method('check')
            ->with($expected)
            ->willReturn(true);
        
        $this->vo_factory->expects($this->once())
            ->method('ast')
            ->with($ast)
            ->willReturn($mock_validator);
    
        $this->validator_repo->expects($this->once())
            ->method('fetch')
            ->with($id)
            ->willReturn($ast);

        $this->assertTrue($this->validator->check($id, $expected));
    }
} 