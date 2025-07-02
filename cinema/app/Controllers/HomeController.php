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
    $proiezioneModel = new \App\Models\Proiezione();
    $today = date('Y-m-d');
    $tomorrow = date('Y-m-d', strtotime('+1 day'));
    $endDate = date('Y-m-d', strtotime('+30 days'));

    // Ottiene l'orario attuale per il confronto
    $currentTime = date('H:i:s');

    // Query modificata per escludere le proiezioni passate di oggi
    $proiezioni = $proiezioneModel
        // Inizia un gruppo di condizioni: ( ... )
        ->groupStart()
            // Condizione A: la data è nel futuro (dopo oggi)
            ->where('data >', $today)
            // O (OR) un altro gruppo di condizioni annidate
            ->orGroupStart()
                // Condizione B: la data è oggi E l'orario è nel futuro
                ->where('data', $today)
                ->where('orario >', $currentTime)
            ->groupEnd()
        ->groupEnd()
        // E la data deve essere entro il nostro limite di 30 giorni
        ->where('data <=', $endDate)
        ->orderBy('data', 'ASC')
        ->orderBy('orario', 'ASC')
        ->findAll();

    $contenutiConProiezioni = [];
    foreach ($proiezioni as $proiezione) {
        $contenuto = $proiezione->getFilm() ?? $proiezione->getSpettacolo();
        if (!$contenuto) continue;

        $contenutoKey = ($proiezione->film_id ? 'film_' : 'spettacolo_') . $contenuto->id;

        if (!isset($contenutiConProiezioni[$contenutoKey])) {
            $contenutiConProiezioni[$contenutoKey] = [
                'contenuto' => $contenuto,
                'tipo' => $proiezione->film_id ? 'film' : 'spettacolo',
                'proiezioni_oggi' => [],
                'proiezioni_domani' => [],
            ];
        }
        if ($proiezione->data == $today) {
            $contenutiConProiezioni[$contenutoKey]['proiezioni_oggi'][] = $proiezione;
        } elseif ($proiezione->data == $tomorrow) {
            $contenutiConProiezioni[$contenutoKey]['proiezioni_domani'][] = $proiezione;
        }
    }

    $data = [
        'films_e_spettacoli' => $contenutiConProiezioni,
        'tutte_le_proiezioni' => $proiezioni, // Sada šaljemo već filtriranu listu
        'dataOggi' => $today
    ];

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