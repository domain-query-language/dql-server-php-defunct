<?php namespace Infrastructure\App\Interpreter\VisitorPattern;

use App\Interpreter;

class Interpreter implements Visitor
{ 
    use VisitorTrait;
    
    private $applied_events = []; 
    private $context;
    private $invariant_repository;
    
    public function __construct(
        \App\Interpreter\Context $context,
        Interpreter\InvariantRepository $invariant_repository)
    {
        $this->context = $context;
        $this->invariant_repository = $invariant_repository;
    }
    
    public function visit_ast_handler(AST\Handler $ast)
    {
        foreach ($ast->statements as $statement) {
            $this->visit($statement);
        }
        return $this->applied_events;
    }
    
    public function visit_ast_apply(AST\Apply $ast)
    {
        if (isset($ast->assert)) {
            if (!$this->check_invariant($ast->assert)) {
                return;
            }
        }
        
        $applied_event = $this->build_event($ast);
        
        $this->applied_events[] = $applied_event;
    }
    
    private function check_invariant($ast)
    {
        $arguments = $this->build_arguments_list($ast->arguments);
     
        $invariant_ast = $this->invariant_repository->fetch($ast->invariant_id);
        
        $result = $this->visit($invariant_ast);
        
        if ($ast->comparator == 'not') {
            return !$result;
        }
        
        return $result;
    }
    
    private function build_arguments_list($ast)
    {
        return  array_map(function($argument) {
            return $this->visit($argument);
        }, $ast);
    }
    
    public function visit_ast_invariant(AST\Invariant $ast)
    {
        return $ast->result;
    }
    
    private function build_event($ast)
    {        
        $arguments = $this->build_arguments_list($ast->arguments);
        
        $event = new \stdClass();
        $event->id = 'event_id';
        
        return $event;
    }

    public function visit_ast_argument(AST\Argument $ast)
    {
        return $this->context->get_property($ast->property);
    }

    public function visit_ast_assert(AST\Assert $ast)
    {
        if (!$this->check_invariant($ast)) {
            throw new Interpreter\InvariantException("Failure");
        }
    }
}