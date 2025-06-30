<?php

namespace App\Models;

use CodeIgniter\Model;

class FasciaOraria extends Model
{
    protected $table            = 'fasce_orarie';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nome', 'orario'];
    protected $useTimestamps    = false; // Questa tabella non ha i campi created_at/updated_at
    protected $returnType = 'object';
}