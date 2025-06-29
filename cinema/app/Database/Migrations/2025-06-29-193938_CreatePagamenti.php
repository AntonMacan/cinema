<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePagamenti extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'SERIAL',
                'null'           => false,
            ],
            'cliente_id'       => ['type' => 'INT'],
            'importo'          => ['type' => 'DECIMAL', 'constraint' => '8,2'],
            'metodo_pagamento' => ['type' => 'VARCHAR', 'constraint' => 50],
            'stato_transazione'=> ['type' => 'VARCHAR', 'constraint' => 30],
            'data'             => [
                'type'    => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
                'null'    => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('cliente_id', 'utenti', 'id', 'NO ACTION', 'RESTRICT');
        $this->forge->createTable('pagamenti');
    }

    public function down()
    {
        $this->forge->dropTable('pagamenti');
    }
}