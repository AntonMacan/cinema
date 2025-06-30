<?php

namespace App\Models;

use CodeIgniter\Model;

class Film extends Model
{
    protected $table            = 'film';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['titolo', 'sinossi', 'cast', 'fornitore_id'];
    protected $useTimestamps    = true;
    protected $returnType = 'object';

    public function proiezioni()
    {
        return $this->hasMany(Proiezione::class, 'film_id', 'id');
    }

    public function fornitore()
    {
        return $this->belongsTo(Fornitore::class, 'fornitore_id', 'id');
    }
}