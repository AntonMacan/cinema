<?php

namespace App\Controllers;

use App\Models\Utente;

class UtenteController extends BaseController
{
    /**
     * Gestisce la registrazione di un nuovo utente.
     * Mostra il form (GET) e processa i dati inviati (POST).
     */
    public function register()
    {
        // Carica gli helper necessari per i form e gli URL
        helper(['form', 'url']);

        // Definisce le regole di validazione per i dati del form
        $rules = [
            'nome'           => 'required|min_length[3]|max_length[50]',
            'email'          => 'required|min_length[6]|max_length[50]|valid_email|is_unique[utenti.email]', // L'email deve essere unica nella tabella 'utenti'
            'password'       => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'matches[password]', // Deve corrispondere al campo 'password'
            'codice_fiscale' => 'required|exact_length[16]',
            'data_nascita'   => 'required|valid_date'
        ];

        // Controlla se la richiesta è di tipo POST (cioè se il form è stato inviato)
        if ($this->request->is('POST')) {
            
            // Esegue la validazione basata sulle regole definite sopra
            if ($this->validate($rules)) {
                
                // --- SE LA VALIDAZIONE HA SUCCESSO ---

                // Crea una nuova istanza del modello Utente
                $userModel = new \App\Models\Utente();

                // Prepara l'array di dati da salvare nel database
                $data = [
                    'nome'           => $this->request->getPost('nome'),
                    'email'          => $this->request->getPost('email'),
                    'password'       => $this->request->getPost('password'),
                    'codice_fiscale' => $this->request->getPost('codice_fiscale'),
                    'data_nascita'   => $this->request->getPost('data_nascita'),
                    'ruolo'          => 'cliente' // Ogni nuovo utente registrato è un 'cliente' di default
                ];

                // Salva i dati del nuovo utente nel database
                $userModel->save($data);

                // Reindirizza alla pagina di login con un messaggio di successo nella sessione
                return redirect()->to('/login')->with('success', 'Registrazione completata! Ora puoi effettuare il login.');

            } else {
                // --- SE LA VALIDAZIONE FALLISCE ---

                // Passa i dati di validazione (con gli errori) di nuovo alla vista
                $data['validation'] = $this->validator;
                return view('register', $data);
            }
        } 
        
        // Se la richiesta è di tipo GET (primo caricamento della pagina), mostra semplicemente la vista
        return view('register');
    }


    /**
     * Metodo per il login degli utenti esistenti.
     */
    public function login()
    {
        helper(['form', 'url']);

        // Se l'utente è già loggato, reindirizzalo alla dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->is('POST')) {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required',
            ];

            if ($this->validate($rules)) {
                $model = new Utente();
                
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');

                // Trova l'utente tramite email
                $user = $model->where('email', $email)->first();

                // Controlla se l'utente esiste e se la password è corretta
                if ($user && password_verify($password, $user->password)) {
                    
                    // Imposta i dati della sessione
                    $sessionData = [
                        'user_id'    => $user->id,
                        'nome'       => $user->nome,
                        'email'      => $user->email,
                        'ruolo'      => $user->ruolo,
                        'isLoggedIn' => true,
                    ];
                    session()->set($sessionData);

                    // Reindirizza a una pagina protetta (dashboard)
                    return redirect()->to('/dashboard')->with('success', 'Login effettuato con successo!');

                } else {
                    // Se l'utente non esiste o la password è sbagliata
                    return redirect()->back()->withInput()->with('error', 'Email o password non validi.');
                }
            } else {
                // Se la validazione di base fallisce
                $data['validation'] = $this->validator;
                return view('login', $data);
            }
        }

        // Se è una richiesta GET, mostra semplicemente il form di login
        return view('login');
    }


     /**
     * Esegue il logout dell'utente distruggendo la sessione.
     */
    public function logout()
    {
        // Distrugge tutti i dati della sessione
        session()->destroy();
        
        // Reindirizza alla pagina di login con un messaggio
        return redirect()->to('/login')->with('success', 'Sei stato disconnesso con successo.');
    }
}