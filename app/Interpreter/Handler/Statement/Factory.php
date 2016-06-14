<?php namespace App\Interpreter\Handler\Statement;

use App\Interpreter\Handler\Assert;
use App\Interpreter\Handler\Apply;

class Factory
{    
    private $assert_factory;
    private $apply_factory;
    
    public function __construct(Assert\Factory $assert_factory, Apply\Factory $apply_factory)
    {
        $this->assert_factory = $assert_factory;
        $this->apply_factory = $apply_factory;
    }
    
    public function ast($ast)
    {
        if ($ast->assert) {
            return $this->assert_factory->ast($ast->assert);
        } else {
            return $this->apply_factory->ast($ast->apply);
        }
    }
}

