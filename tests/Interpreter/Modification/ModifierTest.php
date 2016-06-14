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
        $this->modifier_repo = 
                $this->getMockBuilder(Modification\AstRepository::class)->getMock();
        
        $modifier_factory_class = Modification\Factory::class;
        $this->modifier_factory = $this->getMockBuilder($modifier_factory_class)
            ->disableOriginalConstructor()->getMock();

        $this->modifier = new Modification\Modifier($this->modifier_repo, $this->modifier_factory);
    }
    
    public function test_modifier_stores_modifier_schema()
    {
        $ast = $this->ast_repo->event_handler();
        $this->modifier_repo->expects($this->once())
            ->method('store')
            ->with($ast);
        
        $this->modifier->create($ast);
    }

    public function test_modifier_calls_modifier_and_returns_result()
    {
        $root = 'root';
        $event = 'event';
        $expected = 'modifier_root';
        
        $ast = $this->ast_repo->event_handler();
        
        $modifier_class = Modification\Interpreter::class;
        $mock_modifier= $this->getMockBuilder($modifier_class)
            ->disableOriginalConstructor()->getMock();
        
        $mock_modifier->expects($this->once())
            ->method('modify')
            ->with($root, $event)
            ->willReturn($expected);
        
        $this->modifier_repo->expects($this->once())
            ->method('fetch')
            ->with($this->modifier_id)
            ->willReturn($ast);
        
        $this->modifier_factory->expects($this->once())
            ->method('ast')
            ->with($ast)
            ->willReturn($mock_modifier);
        
        $actual_modification = $this->modifier->modify($this->modifier_id, $root, $event);
        
        $this->assertEquals($expected, $actual_modification);
    }
} 