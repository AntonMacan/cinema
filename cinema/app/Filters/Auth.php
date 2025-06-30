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
        // Ako filter zahtijeva specifičnu ulogu (npr. 'auth:gestore')
        if (!empty($arguments)) {
            $requiredRole = $arguments[0];
            $userRole = session()->get('ruolo');

            // Ako korisnikova uloga nije ona koja se traži
            if ($userRole !== $requiredRole) {
                // Preusmjeri ga na dashboard s porukom o grešci
                // (ili na stranicu s greškom "403 Forbidden")
                return redirect()->to('/dashboard')->with('error', 'Nemate ovlasti za pristup ovoj stranici.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Non facciamo nulla qui
    }
}