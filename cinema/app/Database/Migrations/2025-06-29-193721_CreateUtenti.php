<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUtenti extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => [
            'type' => 'INT',
            'unsigned' => true,
            'auto_increment' => true
        ],
        'nome' => ['type' => 'VARCHAR', 'constraint' => 100],
        'email' => ['type' => 'VARCHAR', 'constraint' => 150],
        'password' => ['type' => 'VARCHAR', 'constraint' => 255],
        'codice_fiscale' => ['type' => 'VARCHAR', 'constraint' => 16],
        'data_nascita' => ['type' => 'DATE'],
        'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
        'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('utenti');
}

public function down()
{
    $this->forge->dropTable('utenti');
}

}
