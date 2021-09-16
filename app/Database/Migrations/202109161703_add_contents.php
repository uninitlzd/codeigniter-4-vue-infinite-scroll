<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddContents extends Migration
{
        public function up()
        {
                $this->forge->addField([
                        'id'          => [
                                'type'           => 'INT',
                                'constraint'     => 5,
                                'unsigned'       => true,
                                'auto_increment' => true,
                        ],
                        'title'       => [
                                'type'       => 'VARCHAR',
                                'constraint' => '100',
                        ],
                        'description' => [
                                'type' => 'TEXT',
                                'null' => true,
                        ],
                ]);
                $this->forge->addKey('id', true);
                $this->forge->createTable('contents');
        }

        public function down()
        {
                $this->forge->dropTable('contents');
        }
}