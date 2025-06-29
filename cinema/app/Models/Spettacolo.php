<?php

namespace App\Models;

use CodeIgniter\Model;

class Spettacolo extends Model
{
    protected $table            = 'spettacoli';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['titolo', 'descrizione', 'cast', 'compagnia_id'];
    protected $useTimestamps    = true;
}