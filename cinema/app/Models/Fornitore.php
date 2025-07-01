<?php

namespace App\Models;

use CodeIgniter\Model;

class Fornitore extends Model
{
    public $id;
    public $nome;
    public $contatto;
    public $created_at;
    public $updated_at;
    
    protected $table            = 'fornitori';
    protected $returnType       = 'App\Models\Fornitore';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nome', 'contatto'];
    protected $useTimestamps    = true;
}