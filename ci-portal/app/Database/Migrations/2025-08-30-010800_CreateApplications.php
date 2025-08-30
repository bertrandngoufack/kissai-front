<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApplications extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'type' => [
                'type'       => 'VARCHAR',
                'constraint' => 16, // web | exe
            ],
            'url' => [
                'type'     => 'VARCHAR',
                'constraint' => 1024,
                'null'     => true,
            ],
            'file_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'file_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 1024,
                'null'       => true,
            ],
            'file_size' => [
                'type' => 'BIGINT',
                'null' => true,
            ],
            'file_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
                'null'       => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tags' => [
                'type' => 'TEXT', // JSON string of tags
                'null' => true,
            ],
            'is_active' => [
                'type'    => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['type', 'is_active']);
        $this->forge->createTable('applications');
    }

    public function down(): void
    {
        $this->forge->dropTable('applications');
    }
}

