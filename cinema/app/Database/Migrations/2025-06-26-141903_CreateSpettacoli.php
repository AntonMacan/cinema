<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSpettacoli extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
            'type' => 'INT',
            'unsigned' => true,
            'auto_increment' => true
            ],
            'titolo'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'descrizione'   => ['type' => 'TEXT'],
            'cast'          => ['type' => 'TEXT'],
            'compagnia_id'  => ['type' => 'INT', 'null' => true],
            'created_at'    => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'    => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('spettacoli');
    }

    public function down()
    {
        $this->forge->dropTable('spettacoli');
    }
}
