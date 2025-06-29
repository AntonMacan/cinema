<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateBiglietti extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'SERIAL', 'null' => false],
            'cliente_id'   => ['type' => 'INT', 'null' => false],
            'proiezione_id'=> ['type' => 'INT', 'null' => false],
            'tipo'         => ['type' => 'VARCHAR', 'constraint' => 20],
            'prezzo'       => ['type' => 'DECIMAL', 'constraint' => '6,2'],
            'pagamento_id' => ['type' => 'INT', 'null' => true],
            'created_at'   => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('cliente_id', 'utenti', 'id', 'NO ACTION', 'CASCADE');
        $this->forge->addForeignKey('proiezione_id', 'proiezioni', 'id', 'NO ACTION', 'CASCADE');
        $this->forge->addForeignKey('pagamento_id', 'pagamenti', 'id', 'NO ACTION', 'SET NULL');
        $this->forge->createTable('biglietti');
    }

    public function down()
    {
        $this->forge->dropTable('biglietti');
    }
}