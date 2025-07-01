<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveOrarioFromFasceOrarie extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('fasce_orarie', 'orario');
    }

    public function down()
    {
        $field = [
            'orario' => [
                'type' => 'TIME',
                'null' => true,
            ]
        ];
        $this->forge->addColumn('fasce_orarie', $field);
    }
}