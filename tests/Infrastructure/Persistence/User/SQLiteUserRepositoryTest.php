<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Infrastructure\Persistence\User\SQLiteUserRepository;
use Tests\TestCase;

class SQLiteUserRepositoryTest extends TestCase
{   
    protected $userRepository;
    
    protected function setUp()
    {
        $pdo = new \PDO('sqlite:' . $_SERVER['PWD'] . '/database.sqlite3','','',[
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);

        $this->userRepository = new SQLiteUserRepository($pdo);
    }

    public function testFindAll()
    {
        $user = $this->userRepository->create('bill.gates@mail.com', 'Bill Gates', '000.000.000.00', '123456', true);
        
        $this->assertGreaterThan(0, count($this->userRepository->findAll()));
    }

    public function testFindUserOfId()
    {
        $user = new User(1, 'bill.gates@mail.com', 'Bill Gates', '000.000.000.00', '', false);

        $this->assertEquals($user, $this->userRepository->findUserOfId(1));
    }

    /**
     * @expectedException \App\Domain\User\UserNotFoundException
     */
    public function testFindUserOfIdThrowsNotFoundException()
    {
        $this->userRepository->findUserOfId(100);
    }
}
