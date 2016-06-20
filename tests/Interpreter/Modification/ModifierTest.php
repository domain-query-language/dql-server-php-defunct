<?php namespace Test\Interpreter\Modification;

use App\Interpreter\Modification;

class ModifierTest extends \Test\Interpreter\TestCase
{    
    private $mock_ast_repo;
    private $mock_factory;
    private $modifier;
    private $modifier_id = '24216a60-fa74-4b80-bfd2-edcfc764db5e';
    
    public function setUp()
    {
        parent::setUp();
        $this->mock_ast_repo = $this->prophesize(Modification\AstRepository::class);
        
        $this->mock_factory = $this->prophesize(Modification\Factory::class);

        $this->modifier = new Modification\Modifier(
            $this->mock_ast_repo->reveal(), 
            $this->mock_factory->reveal()
        );
    }
    
    public function test_modifier_stores_modifier_schema()
    {
        $ast = $this->ast_repo->event_handler();
        
        $this->mock_ast_repo->store($ast)->shouldBeCalled();
        
        $this->modifier->create($ast);
    }

    public function test_modifier_calls_modifier_and_returns_result()
    {
        $root = 'root';
        $event = 'event';
        $expected = 'modifier_root';
        
        $ast = $this->ast_repo->event_handler();
        
        $modifier_class = Modification\Interpreter::class;
        $stub_modifier= $this->stub($modifier_class);
        
        $stub_modifier->modify($root, $event)->willReturn($expected);
        
        $this->mock_ast_repo->fetch($this->modifier_id)->shouldBeCalled()
            ->willReturn($ast);
        
        $this->mock_factory->ast($ast)->shouldBeCalled()
            ->willReturn($stub_modifier);
        
        $actual_modification = $this->modifier->modify($this->modifier_id, $root, $event);
        
        $this->assertEquals($expected, $actual_modification);
    }
} 