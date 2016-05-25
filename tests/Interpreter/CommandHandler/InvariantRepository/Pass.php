<?php namespace Test\Interpreter\CommandHandler\InvariantRepository;

class Pass implements \App\Interpreter\InvariantRepository
{
    public function fetch_ast($id)
    {
        $full_file_path = base_path('tests/Interpreter/asts/invariant.json');
        $ast = json_decode(file_get_contents($full_file_path));        
        return $ast;
    }
}