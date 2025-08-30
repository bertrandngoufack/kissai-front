<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAccessLogs extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'action' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
            ],
            'target_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
                'null'       => true,
            ],
            'target_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 16, // success | failure
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
            'metadata' => [
                'type' => 'LONGTEXT', // JSON
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['action', 'status']);
        $this->forge->addKey(['target_type', 'target_id']);
        $this->forge->createTable('access_logs');
    }

    public function down(): void
    {
        $this->forge->dropTable('access_logs');
    }
}

