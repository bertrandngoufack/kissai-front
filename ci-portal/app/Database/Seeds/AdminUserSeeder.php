<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $passwordHash = password_hash('Admin@12345', PASSWORD_DEFAULT);

        $this->db->table('admin_users')->insert([
            'email'         => 'admin@example.com',
            'password_hash' => $passwordHash,
            'name'          => 'Super Admin',
            'is_active'     => 1,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}

