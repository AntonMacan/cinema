<?php

namespace App\Models;

use CodeIgniter\Model;

class Recensione extends Model
{
    // Proprietà della classe per PHP 8.2+
    public $id;
    public $film_id;
    public $utente_id;
    public $voto;
    public $commento;
    public $created_at;
    public $updated_at;

    protected $table            = 'recensioni';
    protected $returnType       = 'App\Models\Recensione';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = true;
    // Campi permessi per l'inserimento
    protected $allowedFields    = ['film_id', 'utente_id', 'voto', 'commento'];

    /**
     * Relazione: Ogni recensione appartiene a un utente.
     */
    public function utente()
    {
        return $this->belongsTo(Utente::class, 'utente_id');
    }

    /**
     * Relazione: Ogni recensione appartiene a un film.
     */
    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id');
    }

        /**
     * Recupera manualmente l'utente associato (autore della recensione).
     */
    public function getUtente()
    {
        // Ako recenzija nema ID korisnika, vrati null
        if (empty($this->utente_id)) {
            return null;
        }

        // Kreiraj instancu Utente modela i pronađi korisnika po ID-ju
        return (new \App\Models\Utente())->find($this->utente_id);
    }
}