<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFilms extends Migration
{
     public function up()
    {
        $this->forge->addField([
            'id' => [
            'type' => 'INT',
            'unsigned' => true,
            'auto_increment' => true
            ],
            'titolo'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'sinossi'     => ['type' => 'TEXT'],
            'cast'        => ['type' => 'TEXT'],
            'fornitore_id'=> ['type' => 'INT', 'null' => true],
            'created_at'  => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'  => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('fornitore_id', 'fornitori', 'id', 'NO ACTION', 'SET NULL');
        $this->forge->createTable('film');
    }

    public function down()
    {
        $this->forge->dropTable('film');
    }
}
