<?php namespace Test;

use DB;

class DBTest extends \Test\TestCase
{    
    private $db;
    
    public function setUp()
    {
        parent::setUp();
             
        $this->db = DB::connection()->getPdo();
        
        $sql = "CREATE TABLE persons(
            id int,
            first_name varchar(255),
            last_name varchar(255)
        );";
        $this->run_statement($sql);
    }
    
    private function run_statement($sql)
    {
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
    
    public function test_insert_date()
    {
        $integer = new \EventSourced\ValueObject\ValueObject\Integer(1);
        $this->assertEquals(1, $integer->value());
    }
    
    public function test_fetch_data()
    {
        $insert = "INSERT INTO persons (id, first_name, last_name) VALUES (1, 'John', 'Healy');";        
        $this->run_statement($insert);
      
        $query = "SELECT * FROM persons";  
        $rows = $this->run_statement($query);
        
        $expected = [(object)['id'=>'1', 'first_name'=>'John', 'last_name'=>'Healy']];
        
        $this->assertEquals($expected, $rows);
    }
}


