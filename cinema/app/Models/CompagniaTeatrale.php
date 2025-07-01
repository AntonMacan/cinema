<?php

namespace App\Models;

use CodeIgniter\Model;

class CompagniaTeatrale extends Model
{
    public $id;
    public $nome;
    public $contatto;
    public $created_at;
    public $updated_at;

    protected $table            = 'compagnie_teatrali';
    protected $returnType       = 'App\Models\CompagniaTeatrale';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nome', 'contatto'];
    protected $useTimestamps    = true;
}