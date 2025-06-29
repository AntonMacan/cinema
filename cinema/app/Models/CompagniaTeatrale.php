<?php

namespace App\Models;

use CodeIgniter\Model;

class CompagniaTeatrale extends Model
{
    protected $table            = 'compagnie_teatrali';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nome', 'contatto'];
    protected $useTimestamps    = true;
}