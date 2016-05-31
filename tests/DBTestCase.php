<?php namespace Test;

use DB;

class DBTestCase extends TestCase
{    
    protected static $db;
            
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$db = DB::connection()->getPdo();
    }
    
    protected static function run_statement($sql)
    {
        $statement = self::$db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }   
}


