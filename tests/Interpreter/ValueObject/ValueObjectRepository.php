<?php namespace Test\Interpreter\ValueObject;

class ValueObjectRepository implements \App\Interpreter\ValueObjectRepository
{
    public function fetch_ast($id)
    {
        $full_file_path = base_path('tests/Interpreter/asts/valueobject-simple.json');
        return json_decode(file_get_contents($full_file_path));
    }
}
