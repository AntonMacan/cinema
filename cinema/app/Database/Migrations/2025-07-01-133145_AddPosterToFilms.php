<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPosterToFilms extends Migration
{
    public function up()
    {
        $fields = [
            'poster' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true, // Film može postojati i bez postera
                'after'      => 'cast',
            ],
        ];
        $this->forge->addColumn('film', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('films', 'poster');
    }
}