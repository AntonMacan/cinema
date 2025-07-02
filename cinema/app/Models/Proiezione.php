<?php

namespace App\Models;

use CodeIgniter\Model;
use \App\Models\Film;
use \App\Models\Spettacolo;

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

    public function getFilm()
    {
        if (empty($this->film_id)) return null;
        return (new Film())->find($this->film_id);
    }

    public function getSpettacolo()
    {
        if (empty($this->spettacolo_id)) return null;
        return (new Spettacolo())->find($this->spettacolo_id);
    }

    public function getFasciaOraria()
    {
        if (empty($this->fascia_oraria_id)) return null;
        return (new FasciaOraria())->find($this->fascia_oraria_id);
    }

    public function getGestore()
    {
        if (empty($this->gestore_id)) return null;
        return (new Utente())->find($this->gestore_id);
    }
}