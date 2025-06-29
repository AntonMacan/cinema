<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCompagnieTeatrali extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'SERIAL', 'null' => false],
            'nome'       => ['type' => 'VARCHAR', 'constraint' => 200],
            'contatto'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('compagnie_teatrali');
    }

    public function down()
    {
        $this->forge->dropTable('compagnie_teatrali');
    }
}