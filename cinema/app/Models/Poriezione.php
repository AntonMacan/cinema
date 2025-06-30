<?php

namespace App\Models;

use CodeIgniter\Model;

class Proiezione extends Model
{
    protected $table            = 'proiezioni';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'film_id', 
        'spettacolo_id', 
        'fascia_oraria_id', 
        'data', 
        'gestore_id'
    ];
    protected $returnType = 'object';

    protected $useTimestamps    = true;

    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }

    public function spettacolo()
    {
        return $this->belongsTo(Spettacolo::class, 'spettacolo_id', 'id');
    }

    public function fasciaOraria()
    {
        return $this->belongsTo(FasciaOraria::class, 'fascia_oraria_id', 'id');
    }

    public function gestore()
    {
        return $this->belongsTo(Utente::class, 'gestore_id', 'id');
    }
}