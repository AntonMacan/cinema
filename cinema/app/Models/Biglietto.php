<?php

namespace App\Models;

use CodeIgniter\Model;

class Biglietto extends Model
{
    public $id;
    public $cliente_id;
    public $proiezione_id;
    public $tipo;
    public $prezzo;
    public $pagamento_id;
    public $created_at;
    
    protected $table            = 'biglietti';
    protected $returnType       = 'App\Models\Biglietto';
    protected $primaryKey       = 'id';   
    protected $allowedFields    = ['cliente_id', 'proiezione_id', 'tipo', 'prezzo', 'pagamento_id', 'created_at'];
    
    protected $useTimestamps    = false;

    public function getProiezione()
    {
        if (empty($this->proiezione_id)) {
            return null;
        }
        return (new Proiezione())->find($this->proiezione_id);
    }

    public function cliente()
    {
        return $this->belongsTo(Utente::class, 'cliente_id');
    }

    public function pagamento()
    {
        return $this->belongsTo(Pagamento::class, 'pagamento_id');
    }
}