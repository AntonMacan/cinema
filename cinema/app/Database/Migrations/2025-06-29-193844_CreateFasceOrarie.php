<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFasceOrarie extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
            'type' => 'INT',
            'unsigned' => true,
            'auto_increment' => true
            ],
            'nome'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'orario' => ['type' => 'TIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('fasce_orarie');
    }

    public function down()
    {
        $this->forge->dropTable('fasce_orarie');
    }
}
