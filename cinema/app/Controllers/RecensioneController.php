<?php

namespace App\Controllers;

use App\Models\Recensione;

class RecensioneController extends BaseController
{
    /**
     * Salva una nuova recensione nel database.
     */
    public function create()
    {
        $recensioneModel = new Recensione();
        $userId = session()->get('user_id');
        $filmId = $this->request->getPost('film_id');

        // Prevenzione di recensioni multiple
        $recensioneEsistente = $recensioneModel->where('film_id', $filmId)->where('utente_id', $userId)->first();
        if ($recensioneEsistente) {
            return redirect()->back()->with('error', 'Hai già lasciato una recensione per questo film.');
        }

        $data = [
            'film_id'   => $filmId,
            'utente_id' => $userId,
            'voto'      => $this->request->getPost('voto'),
            'commento'  => $this->request->getPost('commento')
        ];

        // Regole di validazione
        $rules = [
            'voto' => 'required|in_list[1,2,3,4,5]',
            'commento' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $recensioneModel->save($data);
        return redirect()->to('/film/' . $filmId)->with('success', 'Recensione inviata con successo!');
    }
}