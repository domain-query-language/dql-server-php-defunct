<?php namespace App\DQLParser;

interface DQLParser 
{   
    public function parse($dql_statement);
}
