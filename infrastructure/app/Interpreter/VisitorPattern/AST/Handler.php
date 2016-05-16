<?php namespace Infrastructure\App\Interpreter\VisitorPattern\AST;

class Handler
{
    public $statements;
    
    public function __construct($ast)
    {
        foreach ($ast->statements as $statement) {
            if ($statement->assert) {
                $this->statements[] = new Assert($statement->assert);
            } else {
                $this->statements[] = new Apply($statement->apply);
            }
        }
    }
}