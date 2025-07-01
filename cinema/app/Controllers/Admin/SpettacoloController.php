<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Spettacolo;
use App\Models\CompagniaTeatrale;

class SpettacoloController extends BaseController
{
    /**
     * Mostra una lista di tutti gli spettacoli.
     */
    public function index()
    {
        $spettacoloModel = new Spettacolo();
        $data = [
            'spettacoli' => $spettacoloModel->findAll()
        ];
        return view('admin/spettacoli/index', $data);
    }

    /**
     * Mostra il form per creare un nuovo spettacolo.
     */
    public function new()
    {
        $compagniaModel = new CompagniaTeatrale();
        $data = [
            'compagnie' => $compagniaModel->findAll()
        ];
        return view('admin/spettacoli/create', $data);
    }

    /**
     * Processa i dati dal form e salva un nuovo spettacolo.
     */
    public function create()
    {
        $rules = [
            'titolo'       => 'required|min_length[3]',
            'descrizione'  => 'required',
            'compagnia_id' => 'required|is_natural_no_zero'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $spettacoloModel = new Spettacolo();
        $data = [
            'titolo'       => $this->request->getPost('titolo'),
            'descrizione'  => $this->request->getPost('descrizione'),
            'cast'         => $this->request->getPost('cast'),
            'compagnia_id' => $this->request->getPost('compagnia_id')
        ];

        $spettacoloModel->save($data);

        return redirect()->to('/admin/spettacoli')->with('success', 'Spettacolo creato con successo.');
    }

    /**
     * Mostra il form per modificare uno spettacolo esistente.
     */
    public function edit($id)
    {
        $spettacoloModel = new Spettacolo();
        $compagniaModel = new CompagniaTeatrale();

        $data = [
            'spettacolo' => $spettacoloModel->find($id),
            'compagnie' => $compagniaModel->findAll()
        ];

        if (empty($data['spettacolo'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the spettacolo with id: ' . $id);
        }

        return view('admin/spettacoli/edit', $data);
    }

    /**
     * Processa i dati dal form di modifica e aggiorna lo spettacolo.
     */
    public function update($id)
    {
        $rules = [
            'titolo'       => 'required|min_length[3]',
            'descrizione'  => 'required',
            'compagnia_id' => 'required|is_natural_no_zero'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $spettacoloModel = new Spettacolo();
        $data = [
            'titolo'       => $this->request->getPost('titolo'),
            'descrizione'  => $this->request->getPost('descrizione'),
            'cast'         => $this->request->getPost('cast'),
            'compagnia_id' => $this->request->getPost('compagnia_id')
        ];

        $spettacoloModel->update($id, $data);

        return redirect()->to('/admin/spettacoli')->with('success', 'Spettacolo aggiornato con successo.');
    }

    /**
     * Elimina uno spettacolo specifico.
     */
    public function delete($id)
    {
        $spettacoloModel = new Spettacolo();
        
        if ($spettacoloModel->find($id)) {
            $spettacoloModel->delete($id);
            return redirect()->to('/admin/spettacoli')->with('success', 'Spettacolo eliminato con successo.');
        }

        return redirect()->to('/admin/spettacoli')->with('error', 'Spettacolo non trovato.');
    }
}