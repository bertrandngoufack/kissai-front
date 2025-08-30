<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuditLogs extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'actor' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'actor_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 32, // admin | system | user
                'default'    => 'system',
            ],
            'event' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
            ],
            'severity' => [
                'type'       => 'VARCHAR',
                'constraint' => 16, // info | warning | error
                'default'    => 'info',
            ],
            'details' => [
                'type' => 'LONGTEXT', // JSON or text
                'null' => true,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['actor_type', 'severity']);
        $this->forge->createTable('audit_logs');
    }

    public function down(): void
    {
        $this->forge->dropTable('audit_logs');
    }
}

