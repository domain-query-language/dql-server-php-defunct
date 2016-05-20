<?php namespace Infrastructure\App\Interpreter\Query;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{
    private $statement;
    private $value_factory;
    
    public function __construct(\PDOStatement $statement, ValueFactory $value_factory)
    {
        $this->statement = $statement;
        $this->value_factory = $value_factory;
    }
        
    public function interpret(Context $context)
    {
        $values = $this->value_factory->context($context);
        $this->statement->execute($values);
        $rows = $this->statement->fetchAll(\PDO::FETCH_OBJ);
        
        if (count($rows) == 0) {
            return false;
        }
        return true;
    }
}