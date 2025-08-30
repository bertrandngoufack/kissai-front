<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOtpCodes extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'code_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
            ],
            'target_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 16, // web | exe
            ],
            'application_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'expires_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'used_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['email', 'target_type']);
        $this->forge->addKey('application_id');
        $this->forge->createTable('otp_codes');
    }

    public function down(): void
    {
        $this->forge->dropTable('otp_codes');
    }
}

