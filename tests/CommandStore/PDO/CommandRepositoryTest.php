<?php namespace Test\EventStore\PDO;

use Infrastructure\App\CommandStore\PDO\CommandRepository;
use Test\CommandStore\AbstractCommandRepositoryTest;

class CommandRepositoryTest extends AbstractCommandRepositoryTest
{    
    protected function build_event_repository()
    {
        $this->artisan('migrate');
        return new CommandRepository(self::$pdo, $this->event_builder);
    }
    
    public function tearDown()
    {
        parent::tearDown();
        $this->artisan('migrate:rollback');
    }
}