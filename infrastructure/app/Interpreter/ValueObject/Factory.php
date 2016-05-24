<?php namespace Infrastructure\App\Interpreter\ValueObject;

use Infrastructure\App\Interpreter\Check;

class Factory 
{    
    private $check_factory;
    private $composite_factory;
    
    public function __construct(
        Check\Factory $check_factory,
        Composite\Factory $composite_factory
    )
    {
        $this->check_factory = $check_factory;
        $this->composite_factory = $composite_factory;
    }
    
    public function ast($ast)
    {
        if (isset($ast->children)) {
           return $this->composite_factory->ast($ast->children, $this);
        }
        return new Interpreter($this->check_factory->ast($ast->check));
    } 
}

