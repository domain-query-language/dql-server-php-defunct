<?php namespace Test\Interpreter\Modification;

use App\Interpreter\Modification;

class ModifierTest extends \Test\Interpreter\TestCase
{    
    private $modifier_repo;
    private $modifier_factory;
    private $modifier;
    private $modifier_id = '24216a60-fa74-4b80-bfd2-edcfc764db5e';
    
    public function setUp()
    {
        parent::setUp();
        $this->modifier_repo = $this->prophesize(Modification\AstRepository::class);
        
        $this->modifier_factory = $this->prophesize(Modification\Factory::class);

        $this->modifier = new Modification\Modifier(
            $this->modifier_repo->reveal(), 
            $this->modifier_factory->reveal()
        );
    }
    
    public function test_modifier_stores_modifier_schema()
    {
        $ast = $this->ast_repo->event_handler();
        $this->modifier_repo->store($ast)->shouldBeCalled();
        
        $this->modifier->create($ast);
    }

    public function test_modifier_calls_modifier_and_returns_result()
    {
        $root = 'root';
        $event = 'event';
        $expected = 'modifier_root';
        
        $ast = $this->ast_repo->event_handler();
        
        $modifier_class = Modification\Interpreter::class;
        $mock_modifier= $this->prophesize($modifier_class);
        
        $mock_modifier->modify($root, $event)->willReturn($expected);
        
        $this->modifier_repo->fetch($this->modifier_id)->shouldBeCalled()
            ->willReturn($ast);
        
        $this->modifier_factory->ast($ast)->shouldBeCalled()
            ->willReturn($mock_modifier);
        
        $actual_modification = $this->modifier->modify($this->modifier_id, $root, $event);
        
        $this->assertEquals($expected, $actual_modification);
    }
} 