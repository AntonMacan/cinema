<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRuoloToUtenti extends Migration
{
    public function up()
    {
        $fields = [
            'ruolo' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
                'default'    => 'cliente',
                'after'      => 'data_nascita' // Opcionalno, postavlja stupac nakon 'data_nascita'
            ],
        ];

        // PAŽNJA: Pobrinite se da je prvi argument 'utenti' ako ste tako nazvali tablicu
        $this->forge->addColumn('utenti', $fields);
    }

    public function down()
    {
        // Ovo služi ako radite rollback migracije
        $this->forge->dropColumn('utenti', 'ruolo');
    }
}