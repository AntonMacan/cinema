<?php

namespace App\Models;

use CodeIgniter\Model;

class Utente extends Model
{
    protected $table            = 'utenti';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'nome',
        'email',
        'password',
        'codice_fiscale',
        'data_nascita',
        'ruolo' // Importante per distinguere i ruoli (cliente, gestore, ecc.)
    ];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $beforeInsert     = ['hashPassword'];
    protected $beforeUpdate     = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }
}