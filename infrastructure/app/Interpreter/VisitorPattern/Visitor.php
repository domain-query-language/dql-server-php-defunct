<?php namespace Infrastructure\App\Interpreter\VisitorPattern;

use Infrastructure\App\Interpreter\VisitorPattern\AST;

interface Visitor
{
    public function visit_ast_apply(AST\Apply $ast);
    
    public function visit_ast_argument(AST\Argument $ast);
    
    public function visit_ast_assert(AST\Assert $ast);
    
    public function visit_ast_handler(AST\Handler $ast);
    
    public function visit_ast_invariant(AST\Invariant $ast);
}