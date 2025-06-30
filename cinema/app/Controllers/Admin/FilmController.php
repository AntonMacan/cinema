<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Film;
use App\Models\Fornitore;

class FilmController extends BaseController
{

    /**
     * Mostra una lista di tutte le risorse film.
     */
    public function index()
    {
        $filmModel = new Film();
        $data = [
            'films' => $filmModel->findAll()
        ];
        return view('admin/films/index', $data);
    }

    /**
     * Mostra il form per creare un nuovo film.
     */
    public function new()
    {
        $fornitoreModel = new Fornitore();
        $data = [
            'fornitori' => $fornitoreModel->findAll()
        ];
        return view('admin/films/create', $data);
    }

    /**
     * Processa i dati dal form e salva un nuovo film.
     */
    public function create()
    {
        $rules = [
            'titolo'       => 'required|min_length[3]',
            'sinossi'      => 'required',
            'fornitore_id' => 'required|is_natural_no_zero'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filmModel = new Film();
        $data = [
            'titolo'       => $this->request->getPost('titolo'),
            'sinossi'      => $this->request->getPost('sinossi'),
            'cast'         => $this->request->getPost('cast'),
            'fornitore_id' => $this->request->getPost('fornitore_id')
        ];

        $filmModel->save($data);

        return redirect()->to('/admin/films')->with('success', 'Film creato con successo.');
    }

    /**
     * Mostra il form per modificare un film esistente.
     * @param int $id ID del film
     */
    public function edit($id)
    {
        $filmModel = new Film();
        $fornitoreModel = new Fornitore();

        $data = [
            'film' => $filmModel->find($id),
            'fornitori' => $fornitoreModel->findAll()
        ];

        if (empty($data['film'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the film with id: ' . $id);
        }

        return view('admin/films/edit', $data);
    }

    /**
     * Processa i dati dal form di modifica e aggiorna il film.
     * @param int $id ID del film
     */
    public function update($id)
    {
        $rules = [
            'titolo'       => 'required|min_length[3]',
            'sinossi'      => 'required',
            'fornitore_id' => 'required|is_natural_no_zero'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filmModel = new Film();
        $data = [
            'titolo'       => $this->request->getPost('titolo'),
            'sinossi'      => $this->request->getPost('sinossi'),
            'cast'         => $this->request->getPost('cast'),
            'fornitore_id' => $this->request->getPost('fornitore_id')
        ];

        $filmModel->update($id, $data);

        return redirect()->to('/admin/films')->with('success', 'Film aggiornato con successo.');
    }

    /**
     * Elimina un film specifico.
     * @param int $id ID del film
     */
    public function delete($id)
    {
        $filmModel = new \App\Models\Film();
        
        if ($filmModel->find($id)) {
            $filmModel->delete($id);
            return redirect()->to('/admin/films')->with('success', 'Film eliminato con successo.');
        }

        return redirect()->to('/admin/films')->with('error', 'Film non trovato.');
    }
}