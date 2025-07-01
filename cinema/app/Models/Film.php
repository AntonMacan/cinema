<?php

namespace App\Models;

use CodeIgniter\Model;

class Film extends Model
{
    public $id;
    public $titolo;
    public $sinossi;
    public $cast;
    public $poster;
    public $fornitore_id;
    public $created_at;
    public $updated_at;

    protected $table            = 'film';
    protected $returnType       = 'App\Models\Film';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['titolo', 'sinossi', 'cast', 'fornitore_id','poster'];
    protected $useTimestamps    = true;

    /**
     * Relazione: Un film appartiene a un fornitore.
     */
    public function fornitore()
    {
        return $this->belongsTo(Fornitore::class, 'fornitore_id');
    }

    /**
     * Relazione: Un film può avere molte proiezioni.
     */
    public function proiezioni()
    {
        return $this->hasMany(Proiezione::class, 'film_id');
    }

    /**
     * Relazione: Un film può avere molte recensioni.
     */
    public function recensioni()
    {
        return $this->hasMany(Recensione::class, 'film_id');
    }
}