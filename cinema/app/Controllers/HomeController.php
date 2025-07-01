<?php

namespace App\Controllers;

use App\Models\Proiezione;
use \App\Models\Film;
use \App\Models\Recensione;

class HomeController extends BaseController
{
    /**
     * Mostra la homepage con la lista di tutte le proiezioni future.
     */
    public function index()
    {
        $proiezioneModel = new Proiezione();
        $today = date('Y-m-d'); // Ottiene la data di oggi

        $data = [
            'proiezioni' => $proiezioneModel
                ->where('data >=', $today) // Solo proiezioni da oggi in poi
                ->orderBy('data', 'ASC')   // Ordina per data (dal più vicino al più lontano)
                ->orderBy('orario', 'ASC')  // Poi ordina per orario
                ->findAll()
        ];

        // Carica la vista della homepage e passa i dati
        return view('home', $data);
    }

    /**
     * Mostra la pagina di dettaglio per un singolo film.
     * @param int $id ID del film
     */
    public function showFilm($id)
    {
        $filmModel = new Film();
        $proiezioneModel = new Proiezione();
        $recensioneModel = new Recensione();
        $today = date('Y-m-d');

        $film = $filmModel->find($id);
        if (!$film) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $recensioni = $recensioneModel->where('film_id', $id)->orderBy('created_at', 'DESC')->findAll();

        // Računanje prosječne ocjene (ostaje isto)
        $totaleRecensioni = count($recensioni);
        $votoMedio = 0;
        if ($totaleRecensioni > 0) {
            $sommaVoti = 0;
            foreach ($recensioni as $recensione) {
                $sommaVoti += $recensione->voto;
            }
            $votoMedio = round($sommaVoti / $totaleRecensioni, 1);
        }

        $data = [
            'film' => $film,
            'proiezioni' => $proiezioneModel->where('film_id', $id)->where('data >=', $today)->orderBy('data', 'ASC')->orderBy('orario', 'ASC')->findAll(),
            'recensioni' => $recensioni,
            'votoMedio' => $votoMedio,
            'totaleRecensioni' => $totaleRecensioni,
        ];

        return view('film_details', $data);
    }

    /**
     * Mostra la pagina di dettaglio per un singolo spettacolo.
     * @param int $id ID dello spettacolo
     */
    public function showSpettacolo($id)
    {
        $spettacoloModel = new \App\Models\Spettacolo();
        $proiezioneModel = new \App\Models\Proiezione();
        $today = date('Y-m-d');

        // Trova lo spettacolo specifico
        $spettacolo = $spettacoloModel->find($id);

        // Se lo spettacolo non viene trovato, mostra un errore 404
        if (!$spettacolo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'spettacolo' => $spettacolo,
            // Trova tutte le proiezioni future per QUESTO spettacolo
            'proiezioni' => $proiezioneModel
                ->where('spettacolo_id', $id)
                ->where('data >=', $today)
                ->orderBy('data', 'ASC')
                ->orderBy('orario', 'ASC')
                ->findAll(),
        ];

        return view('spettacolo_details', $data);
    }
}