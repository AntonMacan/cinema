<?php

namespace App\Models;

use CodeIgniter\Model;

class FasciaOraria extends Model
{
    public $id;
    public $nome;

    protected $table            = 'fasce_orarie';
    protected $returnType       = 'App\Models\FasciaOraria';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nome'];
    protected $useTimestamps    = false;
}