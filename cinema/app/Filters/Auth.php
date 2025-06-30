<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Controlla se la variabile di sessione 'isLoggedIn' non esiste o è false
        if (!session()->get('isLoggedIn')) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Non facciamo nulla qui
    }
}