<?php


use Phinx\Seed\AbstractSeed;

class SeedUsersTable extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Test User',
                'email' => 'test@test.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
            ],
        ];
        $users = $this->table('users');
        $users->insert($data)->saveData();
    }
}
