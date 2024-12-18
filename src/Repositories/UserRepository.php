<?php

namespace App\Repositories;

use App\Database\Database;
use App\Models\User;

class UserRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function createUser(User $user, string $hashedPassword): int
    {
        return $this->db->create('user', [
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'password' => $hashedPassword,
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        $results = $this->db->read(table: 'user', conditions: "email = '$email'");
        return $results ? $results[0] : null;
    }
}
