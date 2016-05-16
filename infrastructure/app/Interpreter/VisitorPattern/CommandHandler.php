<?php namespace Infrastructure\App\Interpreter\VisitorPattern;

use App\Interpreter\InvariantRepository;
use Infrastructure\App\Interpreter\VisitorPattern\AST;

class CommandHandler implements \App\Interpreter\Interpreter
{
    private $invariant_repository;
    private $ast;

    public function __construct(
        InvariantRepository $invariant_repository,
        $ast
    )
    {
        $this->invariant_repository = $invariant_repository;
        $this->ast = new AST\Handler($ast);
    }
        
    public function interpret(\App\Interpreter\Context $context)
    {
        $visitor = new Interpreter($context, $this->invariant_repository);
        
        return $visitor->visit($this->ast);
    }
}