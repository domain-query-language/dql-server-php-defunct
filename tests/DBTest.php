<?php namespace Test;

class DBTest extends DBTestCase
{        
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        
        $sql = "CREATE TABLE persons(
            id int,
            first_name varchar(255),
            last_name varchar(255)
        );";
        self::run_statement($sql);
    }
        
    public function test_insert_and_fetch_data()
    {
        $insert = "INSERT INTO persons (id, first_name, last_name) VALUES (1, 'John', 'Healy');";        
        self::run_statement($insert);
      
        $query = "SELECT * FROM persons";  
        $rows = self::run_statement($query);
        
        $expected = [(object)['id'=>'1', 'first_name'=>'John', 'last_name'=>'Healy']];
        
        $this->assertEquals($expected, $rows);
    }
}


