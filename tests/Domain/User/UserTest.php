<?php
declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function userProvider()
    {
        return [
            [1, 'bill.gates@mail.com', 'Bill Gates', '000.000.000.00', '123456', false],
        ];
    }

    /**
     * @dataProvider userProvider
     * @param $id
     * @param $email
     * @param $nome
     * @param $cpf
     * @param $senha
     * @param $admin
     */
    public function testGetters($id, $email, $nome, $cpf, $senha, $admin)
    {
        $user = new User($id, $email, $nome, $cpf, $senha, $admin);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($nome, $user->getNome());
        $this->assertEquals($cpf, $user->getCpf());
        $this->assertEquals($senha, $user->getSenha());
        $this->assertEquals($admin, $user->getAdmin());
    }

    /**
     * @dataProvider userProvider
     * @param $id
     * @param $email
     * @param $nome
     * @param $cpf
     * @param $senha
     * @param $admin
     */
    public function testJsonSerialize($id, $email, $nome, $cpf, $senha, $admin)
    {
        $user = new User($id, $email, $nome, $cpf, $senha, $admin);

        $expectedPayload = json_encode([
            'id' => $id,
            'email' => $email,
            'nome' => $nome,
            'cpf' => $cpf,
            'admin' => $admin,
            'agendas' => [],
        ]);

        $this->assertEquals($expectedPayload, json_encode($user));
    }
}
