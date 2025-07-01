<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRecensioni extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'SERIAL', 'null' => false],
            'film_id'    => ['type' => 'INT', 'null' => false],
            'utente_id'  => ['type' => 'INT', 'null' => false],
            'voto'       => ['type' => 'INT', 'constraint' => 1], // Voto da 1 a 5
            'commento'   => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('film_id', 'film', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('utente_id', 'utenti', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('recensioni');
    }

    public function down()
    {
        $this->forge->dropTable('recensioni');
    }
}