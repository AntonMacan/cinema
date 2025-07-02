<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Proiezione;
use App\Models\Film;
use App\Models\Spettacolo;
use App\Models\FasciaOraria;

class ProiezioneController extends BaseController
{
    /**
     * Mostra una lista di tutte le proiezioni.
     */
    public function index()
    {
        $proiezioneModel = new Proiezione();
        $data = [
           'proiezioni' => $proiezioneModel->orderBy('data', 'DESC')->orderBy('orario', 'DESC')->paginate(15),
           'pager' => $proiezioneModel->pager
        ];
        return view('admin/proiezioni/index', $data);
    }

    /**
     * Mostra il form per creare una nuova proiezione.
     */
    public function new()
    {
        $data = [
            'films' => (new Film())->findAll(),
            'spettacoli' => (new Spettacolo())->findAll(),
            'fasce_orarie' => (new FasciaOraria())->findAll()
        ];
        return view('admin/proiezioni/create', $data);
    }

   /**
     * Processa i dati dal form e salva una nuova proiezione,
     * determinando automaticamente la fascia oraria.
     */
    public function create()
    {
        $rules = [
            'data'   => 'required|valid_date',
            'orario' => 'required', // Fascia oraria non è più richiesta dall'utente
            'film_id' => 'permit_empty|is_natural_no_zero',
            'spettacolo_id' => 'permit_empty|is_natural_no_zero'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filmId = $this->request->getPost('film_id');
        $spettacoloId = $this->request->getPost('spettacolo_id');
        $orario = $this->request->getPost('orario');

        if (empty($filmId) && empty($spettacoloId)) {
            return redirect()->back()->withInput()->with('error', 'Errore: Devi selezionare un film OPPURE uno spettacolo.');
        }
        if (!empty($filmId) && !empty($spettacoloId)) {
            return redirect()->back()->withInput()->with('error', 'Errore: Non puoi selezionare sia un film CHE uno spettacolo.');
        }

        // --- NUOVA LOGICA AUTOMATICA ---
        $fascia_oraria_id = 0;
        if ($orario < '13:00') {
            $fascia_oraria_id = 1; // Mattina
        } elseif ($orario < '19:00') {
            $fascia_oraria_id = 2; // Pomeriggio
        } else {
            $fascia_oraria_id = 3; // Sera
        }
        // -----------------------------

        $proiezioneModel = new Proiezione();
        $data = [
            'data'             => $this->request->getPost('data'),
            'orario'           => $orario,
            'fascia_oraria_id' => $fascia_oraria_id, // Sprema se automatski određen ID
            'film_id'          => $filmId ?: null,
            'spettacolo_id'    => $spettacoloId ?: null,
            'gestore_id'       => session()->get('user_id')
        ];

        $proiezioneModel->save($data);
        return redirect()->to('/admin/proiezioni')->with('success', 'Proiezione creata con successo.');
    }

    /**
     * Processa i dati dal form di modifica e aggiorna la proiezione,
     * determinando automaticamente la fascia oraria.
     */
    public function update($id)
    {
        $rules = [
            'data'   => 'required|valid_date',
            'orario' => 'required',
            'film_id' => 'permit_empty|is_natural_no_zero',
            'spettacolo_id' => 'permit_empty|is_natural_no_zero'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', 'Dati non validi.');
        }

        $filmId = $this->request->getPost('film_id');
        $spettacoloId = $this->request->getPost('spettacolo_id');
        $orario = $this->request->getPost('orario');
        
        if (empty($filmId) && empty($spettacoloId)) {
            return redirect()->back()->withInput()->with('error', 'Errore: Devi selezionare un film OPPURE uno spettacolo.');
        }
        if (!empty($filmId) && !empty($spettacoloId)) {
            return redirect()->back()->withInput()->with('error', 'Errore: Non puoi selezionare sia un film CHE uno spettacolo.');
        }

        // --- NUOVA LOGICA AUTOMATICA (ISTA KAO U CREATE) ---
        $fascia_oraria_id = 0;
        if ($orario < '13:00') {
            $fascia_oraria_id = 1; // Mattina
        } elseif ($orario < '19:00') {
            $fascia_oraria_id = 2; // Pomeriggio
        } else {
            $fascia_oraria_id = 3; // Sera
        }
        // ----------------------------------------------------

        $proiezioneModel = new Proiezione();
        $data = [
            'data'             => $this->request->getPost('data'),
            'orario'           => $orario,
            'fascia_oraria_id' => $fascia_oraria_id,
            'film_id'          => $filmId ?: null,
            'spettacolo_id'    => $spettacoloId ?: null,
        ];

        $proiezioneModel->update($id, $data);
        return redirect()->to('/admin/proiezioni')->with('success', 'Proiezione aggiornata con successo.');
    }

    /**
     * Mostra il form per modificare una proiezione esistente.
     * @param int $id ID della proiezione
     */
    public function edit($id)
    {
        $data = [
            'proiezione' => (new Proiezione())->find($id),
            'films' => (new Film())->findAll(),
            'spettacoli' => (new Spettacolo())->findAll(),
            'fasce_orarie' => (new FasciaOraria())->findAll()
        ];

        if (empty($data['proiezione'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the proiezione with id: ' . $id);
        }

        return view('admin/proiezioni/edit', $data);
    }

     /**
     * Elimina una proiezione specifica.
     * @param int $id ID della proiezione
     */
    public function delete($id)
    {
        $proiezioneModel = new Proiezione();
        
        if ($proiezioneModel->find($id)) {
            $proiezioneModel->delete($id);
            return redirect()->to('/admin/proiezioni')->with('success', 'Proiezione eliminata con successo.');
        }

        return redirect()->to('/admin/proiezioni')->with('error', 'Proiezione non trovata.');
    }
    
}