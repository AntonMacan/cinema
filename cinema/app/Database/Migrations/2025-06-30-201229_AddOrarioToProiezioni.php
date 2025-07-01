<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOrarioToProiezioni extends Migration
{
    public function up()
    {
        $fields = [
            'orario' => [
                'type' => 'TIME',
                'null' => false,
                'after' => 'data'
            ]
        ];
        $this->forge->addColumn('proiezioni', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('proiezioni', 'orario');
    }
}