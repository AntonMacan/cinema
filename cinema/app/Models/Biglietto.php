<?php

namespace App\Models;

use CodeIgniter\Model;

class Biglietto extends Model
{
    protected $table            = 'biglietti';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['cliente_id', 'proiezione_id', 'tipo', 'prezzo', 'pagamento_id', 'created_at'];
    
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = null;

    public function proiezione()
    {
        return $this->belongsTo(Proiezione::class, 'proiezione_id', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id', 'id');
    }

    public function pagamento()
    {
        return $this->belongsTo(Pagamento::class, 'pagamento_id', 'id');
    }
}