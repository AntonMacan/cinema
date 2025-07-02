<?php

namespace App\Models;

use CodeIgniter\Model;

class Pagamento extends Model
{
    public $id;
    public $cliente_id;
    public $importo;
    public $metodo_pagamento;
    public $stato_transazione;
    public $data;

    protected $table            = 'pagamenti';
    protected $returnType       = 'App\Models\Pagamento';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['cliente_id', 'importo', 'metodo_pagamento', 'stato_transazione', 'data'];
    protected $useTimestamps    = false;
    
    public function cliente()
    {
        return $this->belongsTo(Utente::class, 'cliente_id');
    }

    public function getBiglietti()
    {
        return (new \App\Models\Biglietto())->where('pagamento_id', $this->id)->findAll();
    }
}