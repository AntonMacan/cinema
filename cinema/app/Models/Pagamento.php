<?php

namespace App\Models;

use CodeIgniter\Model;

class Pagamento extends Model
{
    protected $table            = 'pagamenti';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['cliente_id', 'importo', 'metodo_pagamento', 'stato_transazione', 'data'];
    protected $useTimestamps    = false; // Qui il timestamp della transazione è gestito dal campo 'data'
    protected $returnType = 'object';
}