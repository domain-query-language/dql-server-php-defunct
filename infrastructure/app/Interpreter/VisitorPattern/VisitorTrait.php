<?php namespace Infrastructure\App\Interpreter\VisitorPattern;

trait VisitorTrait
{
    public function visit($ast)
    {
        $class = str_replace("Infrastructure\\App\\Interpreter\\VisitorPattern\\AST\\", "", get_class($ast));
        
        $handler = "visit_ast_".snake_case($class);
        
        return $this->$handler($ast);
    }
}