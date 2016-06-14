<?php namespace App\Interpreter\Query;

class Interpreter
{
    private $statement;
    private $value_factory;
    
    public function __construct(\PDOStatement $statement, ValueFactory $value_factory)
    {
        $this->statement = $statement;
        $this->value_factory = $value_factory;
    }
        
    public function query($rrot)
    {
        $values = $this->value_factory->context($rrot);
        $this->statement->execute($values);
        $rows = $this->statement->fetchAll(\PDO::FETCH_OBJ);
        
        return (object)$rows[0];
    }
}