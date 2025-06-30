<?php

namespace App\Controllers;

use App\Models\Utente;

class UtenteController extends BaseController
{
    public function register()
    {
        helper(['form', 'url']);

        // Provjeravamo je li metoda POST (tj. je li forma poslana)
        if ($this->request->getMethod() === 'POST') {

            // Ostatak koda se neće izvršiti zbog dd() iznad.

            $rules = [
                'nome'           => 'required|min_length[3]|max_length[50]',
                'email'          => 'required|min_length[6]|max_length[50]|valid_email|is_unique[utenti.email]',
                'password'       => 'required|min_length[8]|max_length[255]',
                'password_confirm' => 'matches[password]',
                'codice_fiscale' => 'required|exact_length[16]',
                'data_nascita'   => 'required|valid_date'
            ];
            
            if ($this->validate($rules)) {
                $userModel = new Utente();
                $data = [
                    'nome'     => $this->request->getPost('nome'),
                    'email'    => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password'),
                    'codice_fiscale' => $this->request->getPost('codice_fiscale'),
                    'data_nascita'   => $this->request->getPost('data_nascita'),
                    'ruolo'          => 'cliente'
                ];
                $userModel->save($data);
                return redirect()->to('/login')->with('success', 'Registracija uspješna! Možete se prijaviti.');
            } else {
                dd($this->validator->getErrors()); 
            }
        } 
        
        // Ako zahtjev nije POST (npr. prvi put otvarate stranicu), samo prikaži view
        return view('register');
    }
}