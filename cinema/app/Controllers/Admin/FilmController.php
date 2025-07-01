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
    $filmModel = new \App\Models\Film();

    $data = [
        // Metoda paginate() automatski dohvaća podatke za trenutnu stranicu.
        // Broj 10 označava koliko unosa želimo po stranici.
        'films' => $filmModel->orderBy('id', 'DESC')->paginate(10),

        // Prosljeđujemo 'pager' objekt view-u, on sadrži linkove za navigaciju.
        'pager' => $filmModel->pager
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
    // Aggiungiamo le regole per l'upload del file
    $rules = [
        'titolo'       => 'required|min_length[3]',
        'sinossi'      => 'required',
        'fornitore_id' => 'required|is_natural_no_zero',
        'poster'       => [
            'label' => 'Image File',
            'rules' => 'if_exist|is_image[poster]|mime_in[poster,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[poster,2048]',
        ],
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $file = $this->request->getFile('poster');
    $posterName = null;

    // Se un file è stato caricato ed è valido
    if ($file->isValid() && !$file->hasMoved()) {
        // Genera un nome casuale per evitare conflitti
        $posterName = $file->getRandomName();
        // Sposta il file nella cartella di destinazione
        $file->move(FCPATH . 'uploads/posters', $posterName);
    }

    $filmModel = new \App\Models\Film();
    $data = [
        'titolo'       => $this->request->getPost('titolo'),
        'sinossi'      => $this->request->getPost('sinossi'),
        'cast'         => $this->request->getPost('cast'),
        'fornitore_id' => $this->request->getPost('fornitore_id'),
        'poster'       => $posterName, // Salva il nome del file nel database
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
        'fornitore_id' => 'required|is_natural_no_zero',
        'poster'       => [
            'label' => 'Image File',
            'rules' => 'if_exist|is_image[poster]|mime_in[poster,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[poster,2048]',
        ],
    ];
    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', 'Dati non validi.');
    }

    $filmModel = new Film();
    $oldFilm = $filmModel->find($id);

    $file = $this->request->getFile('poster');
    $posterName = $oldFilm->poster;

    if ($file->isValid() && !$file->hasMoved()) {
        if ($oldFilm->poster && file_exists('uploads/posters/' . $oldFilm->poster)) {
            unlink('uploads/posters/' . $oldFilm->poster);
        }
        $posterName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/posters', $posterName);
    }

    $data = [
        'titolo'       => $this->request->getPost('titolo'),
        'sinossi'      => $this->request->getPost('sinossi'),
        'cast'         => $this->request->getPost('cast'),
        'fornitore_id' => $this->request->getPost('fornitore_id'),
        'poster'       => $posterName,
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