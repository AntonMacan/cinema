<?php

namespace App\Models;

use CodeIgniter\Model;

class Fornitore extends Model
{
    protected $table            = 'fornitori';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nome', 'contatto'];
    protected $useTimestamps    = true;
    protected $returnType = 'object';
}