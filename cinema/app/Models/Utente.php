<?php

namespace App\Models;

use CodeIgniter\Model;

class Utente extends Model
{
    // Dichiarazione delle proprietà della classe per PHP 8.2+
    public $id;
    public $nome;
    public $email;
    public $password;
    public $codice_fiscale;
    public $data_nascita;
    public $ruolo;
    public $status;
    public $verification_token;
    public $created_at;
    public $updated_at;

    protected $table            = 'utenti';
    protected $returnType       = 'App\Models\Utente';
    protected $primaryKey       = 'id';
    
    protected $allowedFields    = [
        'nome', 'email', 'password', 'codice_fiscale', 'data_nascita', 'ruolo','status', 'verification_token'
    ];

    protected $useTimestamps    = true;
    protected $beforeInsert     = ['hashPassword'];
    protected $beforeUpdate     = ['hashPassword'];

    /**
     * Esegue l'hashing della password prima di salvarla.
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * Relazione: Un utente (gestore) può avere molte proiezioni.
     */
    public function proiezioni()
    {
        return $this->hasMany(Proiezione::class, 'gestore_id');
    }

    /**
     * Relazione: Un utente (cliente) può avere molti biglietti.
     */
    public function biglietti()
    {
        return $this->hasMany(Biglietto::class, 'cliente_id');
    }
}