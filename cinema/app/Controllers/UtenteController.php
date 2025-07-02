<?php

namespace App\Controllers;

use App\Models\Utente;
use App\Models\Pagamento;

class UtenteController extends BaseController
{
    /**
 * Gestisce la registrazione di un nuovo utente.
 * Salva l'utente come inattivo e invia un'email di verifica.
 */
public function register()
{
    helper(['form', 'url', 'text']); // Dodajemo 'text' helper za random string

        // Definisce le regole di validazione per i dati del form
        $rules = [
            'nome'           => 'required|min_length[3]|max_length[50]',
            'email'          => 'required|min_length[6]|max_length[50]|valid_email|is_unique[utenti.email]', // L'email deve essere unica nella tabella 'utenti'
            'password'       => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'matches[password]', // Deve corrispondere al campo 'password'
            'codice_fiscale' => 'required|exact_length[16]',
            'data_nascita'   => 'required|valid_date'
        ];

    if ($this->request->is('POST') && $this->validate($rules)) {
        $userModel = new \App\Models\Utente();

        // Genera un token di verifica unico e casuale
        $token = random_string('crypto', 50);

        $data = [
            'nome'           => $this->request->getPost('nome'),
            'email'          => $this->request->getPost('email'),
            'password'       => $this->request->getPost('password'),
            'codice_fiscale' => $this->request->getPost('codice_fiscale'),
            'data_nascita'   => $this->request->getPost('data_nascita'),
            'ruolo'          => 'cliente',
            'status'         => 'inactive', // L'account è inattivo
            'verification_token' => $token // Salviamo il token
        ];

        $userModel->save($data);

        // Invia l'email di verifica
        $email = \Config\Services::email();
        $email->setTo($data['email']);
        $email->setFrom('info@cinema-teatro.com', 'Cinema-Teatro');
        $email->setSubject('Attiva il tuo account');

        $verificationLink = site_url('verify/' . $token);
        $message = "<h1>Benvenuto in Cinema-Teatro!</h1>";
        $message .= "<p>Grazie per esserti registrato. Per favore, clicca sul link sottostante per attivare il tuo account:</p>";
        $message .= "<a href='{$verificationLink}'>Attiva il mio account</a>";
        $email->setMessage($message);
        $email->send();

        // Mostra una pagina di avviso all'utente
        return view('activation_message');
    } else {
        $data['validation'] = $this->validator;
        return view('register', $data);
    }
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

                if ($user && $user->status !== 'active') {
                    return redirect()->back()->withInput()->with('error', 'Il tuo account non è stato ancora attivato. Controlla la tua email per il link di attivazione.');
                }
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

                    // Reindirizza alla pagina principale
                    return redirect()->to('/')->with('success', 'Login effettuato con successo!');

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

    /**
     * Mostra la pagina del ticketso dell'utente con la cronologia dei biglietti.
     */
    public function tickets()
    {
        $pagamentoModel = new Pagamento();
        $userId = session()->get('user_id');

        $data = [
            'pagamenti' => $pagamentoModel->where('cliente_id', $userId)
                                        ->orderBy('data', 'DESC')
                                        ->findAll()
        ];


        // Carica la vista del ticketso e passa i dati
        return view('tickets', $data);
    }

    /**
     * Verifica l'account di un utente tramite il token inviato via email.
     * @param string $token
     */
    public function verify($token)
    {
        $userModel = new Utente();

        // Trova l'utente con il token specificato
        $user = $userModel->where('verification_token', $token)->first();

        if ($user) {
            // Se l'utente viene trovato, aggiorna il suo stato ad 'attivo'
            $data = [
                'status' => 'active',
                'verification_token' => null // Pulisci il token
            ];
            $userModel->update($user->id, $data);

            // Reindirizza alla pagina di login con un messaggio di successo
            return redirect()->to('/login')->with('success', 'Il tuo account è stato attivato con successo! Ora puoi effettuare il login.');
        } else {
            // Se il token non è valido, mostra un messaggio di errore
            return redirect()->to('/login')->with('error', 'Token di verifica non valido o scaduto.');
        }
    }

    /**
 * Mostra il form per modificare il profilo e processa i dati inviati.
 */
public function profile()
{
    helper(['form']);
    $userModel = new Utente();
    $userId = session()->get('user_id');

    // Se la richiesta è POST, processa i dati del form
    if ($this->request->is('POST')) {
        $action = $this->request->getPost('action');

        // --- Logica per aggiornare i dati dell'utente ---
        if ($action === 'update_details') {
            $rules = ['nome' => 'required|min_length[3]|max_length[50]'];

            if ($this->validate($rules)) {
                $newData = ['nome' => $this->request->getPost('nome')];
                $userModel->update($userId, $newData);

                // Aggiorna anche il nome nella sessione!
                session()->set('nome', $newData['nome']);
                return redirect()->to('/profile')->with('success', 'Dati aggiornati con successo.');
            }
        }

        // --- Logica per cambiare la password ---
        if ($action === 'update_password') {
            $rules = [
                'current_password' => 'required',
                'new_password'     => 'required|min_length[8]',
                'password_confirm' => 'matches[new_password]'
            ];

            if ($this->validate($rules)) {
                $user = $userModel->find($userId);
                $currentPassword = $this->request->getPost('current_password');
                $newPassword = $this->request->getPost('new_password');

                // Controlla se la password attuale è corretta
                if (password_verify($currentPassword, $user->password)) {
                    $userModel->update($userId, ['password' => $newPassword]); // Il modello farà l'hashing automaticamente
                    return redirect()->to('/profile')->with('success', 'Password cambiata con successo.');
                } else {
                    return redirect()->back()->withInput()->with('error', 'La password attuale non è corretta.');
                }
            }
        }
    }

    // Se la richiesta è GET, mostra semplicemente il form con i dati attuali
    $data = [
        'utente' => $userModel->find($userId),
        'validation' => $this->validator // Passa il validatore per mostrare gli errori
    ];

    return view('profile', $data);
}
}