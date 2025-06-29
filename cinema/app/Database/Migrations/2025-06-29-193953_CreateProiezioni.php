<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateProiezioni extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'SERIAL', 'null' => false],
            'film_id'         => ['type' => 'INT', 'null' => true],
            'spettacolo_id'   => ['type' => 'INT', 'null' => true],
            'fascia_oraria_id'=> ['type' => 'INT', 'null' => false],
            'data'            => ['type' => 'DATE'],
            'gestore_id'      => ['type' => 'INT', 'null' => false],
            'created_at'      => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'      => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('film_id', 'film', 'id', 'NO ACTION', 'CASCADE');
        $this->forge->addForeignKey('spettacolo_id', 'spettacoli', 'id', 'NO ACTION', 'CASCADE');
        $this->forge->addForeignKey('fascia_oraria_id', 'fasce_orarie', 'id', 'NO ACTION', 'RESTRICT');
        $this->forge->addForeignKey('gestore_id', 'utenti', 'id', 'NO ACTION', 'RESTRICT'); 
        $this->forge->createTable('proiezioni');
    }

    public function down()
    {
        $this->forge->dropTable('proiezioni');
    }
}