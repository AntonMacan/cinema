<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVerificationToUtenti extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
                'default'    => 'inactive',
                'after'      => 'ruolo',
            ],
            'verification_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'status',
            ],
        ];
        $this->forge->addColumn('utenti', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('utenti', ['status', 'verification_token']);
    }
}