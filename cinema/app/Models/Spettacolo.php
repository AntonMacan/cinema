<?php

namespace App\Models;

use CodeIgniter\Model;

class Spettacolo extends Model
{
    public $id;
    public $titolo;
    public $descrizione;
    public $cast;
    public $compagnia_id;
    public $created_at;
    public $updated_at;

    protected $table            = 'spettacoli';
    protected $returnType       = 'App\Models\Spettacolo';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['titolo', 'descrizione', 'cast', 'compagnia_id'];
    protected $useTimestamps    = true;
    
    /**
     * Relazione: Uno spettacolo appartiene a una compagnia.
     */
    public function compagniaTeatrale()
    {
        return $this->belongsTo(CompagniaTeatrale::class, 'compagnia_id');
    }
    
    /**
     * Relazione: Uno spettacolo può avere molte proiezioni.
     */
    public function proiezioni()
    {
        return $this->hasMany(Proiezione::class, 'spettacolo_id');
    }
}