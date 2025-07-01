<?php

namespace App\Models;

use CodeIgniter\Model;

class Proiezione extends Model
{
    public $id;
    public $film_id;
    public $spettacolo_id;
    public $fascia_oraria_id;
    public $data;
    public $orario;
    public $gestore_id;
    public $created_at;
    public $updated_at;

    protected $table            = 'proiezioni';
    protected $returnType       = 'App\Models\Proiezione';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'film_id', 'spettacolo_id', 'fascia_oraria_id', 'data', 'orario', 'gestore_id'
    ];
    protected $useTimestamps    = true;

    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id');
    }

    public function getFilm()
{
    if (empty($this->film_id)) {
        return null;
    }

    $filmModel = new \App\Models\Film();
    return $filmModel->find($this->film_id);
}

    public function spettacolo()
    {
        return $this->belongsTo(Spettacolo::class, 'spettacolo_id');
    }

    public function fasciaOraria()
    {
        return $this->belongsTo(FasciaOraria::class, 'fascia_oraria_id');
    }

    public function gestore()
    {
        return $this->belongsTo(Utente::class, 'gestore_id');
    }
}