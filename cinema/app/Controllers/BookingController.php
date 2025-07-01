<?php

namespace App\Controllers;

use App\Models\Proiezione;
use App\Models\Pagamento;
use App\Models\Biglietto;
use Dompdf\Dompdf;

class BookingController extends BaseController
{
    /**
     * Mostra il primo passo del processo di booking: la selezione dei biglietti.
     * @param int $proiezioneId ID della proiezione selezionata
     */
    public function index($proiezioneId)
    {
        $proiezioneModel = new Proiezione();

        // Trova la proiezione specifica e i suoi dati correlati
        $proiezione = $proiezioneModel->find($proiezioneId);

        // Se la proiezione non esiste, mostra un errore 404
        if (!$proiezione) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Definiamo i tipi di biglietti e i loro prezzi
        // Più tardi, questo potrebbe venire da un'altra tabella nel database
        $tipi_biglietti = [
            ['tipo' => 'Intero', 'prezzo' => 10.00],
            ['tipo' => 'Ridotto', 'prezzo' => 7.50]
        ];

        $data = [
            'proiezione' => $proiezione,
            'tipi_biglietti' => $tipi_biglietti
        ];

        // Carica la vista per l'inizio della prenotazione
        return view('booking/start', $data);
    }

    /**
     * Processa la selezione dei biglietti, crea il pagamento e salva i biglietti.
     */
    public function process()
    {
        // 1. Controlla se l'utente è loggato
        if (!session()->get('isLoggedIn')) {
            // Salva l'URL a cui l'utente voleva andare
            session()->set('redirect_url', previous_url());
            return redirect()->to('/login')->with('error', 'Devi effettuare il login per acquistare i biglietti.');
        }

        // Recupera i dati dal form
        $proiezioneId = $this->request->getPost('proiezione_id');
        $bigliettiSelezionati = $this->request->getPost('biglietti');

        // Definiamo di nuovo i tipi di biglietti e i loro prezzi
        $tipi_biglietti_info = [
            'intero' => ['tipo' => 'Intero', 'prezzo' => 10.00],
            'ridotto' => ['tipo' => 'Ridotto', 'prezzo' => 7.50]
        ];

        $bigliettiDaSalvare = [];
        $importoTotale = 0.00;
        
        // 2. Calcola il prezzo totale e prepara i dati per ogni biglietto
        foreach ($bigliettiSelezionati as $key => $quantita) {
            if ($quantita > 0) {
                for ($i = 0; $i < $quantita; $i++) {
                    $prezzo = $tipi_biglietti_info[$key]['prezzo'];
                    $importoTotale += $prezzo;
                    
                    $bigliettiDaSalvare[] = [
                        'cliente_id'    => session()->get('user_id'),
                        'proiezione_id' => $proiezioneId,
                        'tipo'          => $tipi_biglietti_info[$key]['tipo'],
                        'prezzo'        => $prezzo,
                        'created_at'    => date('Y-m-d H:i:s')
                    ];
                }
            }
        }

        // Se non è stato selezionato nessun biglietto, torna indietro
        if (empty($bigliettiDaSalvare)) {
            return redirect()->back()->with('error', 'Devi selezionare almeno un biglietto.');
        }

        // 3. Crea il record di pagamento
        $pagamentoModel = new \App\Models\Pagamento();
        $pagamentoData = [
            'cliente_id'       => session()->get('user_id'),
            'importo'          => $importoTotale,
            'metodo_pagamento' => 'PayPal',
            'stato_transazione'=> 'completato'
        ];
        $pagamentoModel->save($pagamentoData);
        $pagamentoId = $pagamentoModel->getInsertID(); // Ottieni l'ID del pagamento appena creato

        // 4. Aggiungi l'ID del pagamento a ogni biglietto e salvali
        foreach ($bigliettiDaSalvare as &$biglietto) {
            $biglietto['pagamento_id'] = $pagamentoId;
        }

        $bigliettoModel = new \App\Models\Biglietto();
        $bigliettoModel->insertBatch($bigliettiDaSalvare); // Salva tutti i biglietti in una sola query

        // 5. Reindirizza alla pagina di successo
        return redirect()->to("/booking/success/{$pagamentoId}");
    }

    /**
     * Mostra la pagina di conferma dopo un acquisto andato a buon fine.
     * @param int $pagamentoId ID del pagamento
     */
    public function success($pagamentoId)
    {
        $pagamentoModel = new \App\Models\Pagamento();
        $bigliettoModel = new \App\Models\Biglietto();

        $data = [
            'pagamento' => $pagamentoModel->find($pagamentoId),
            // Trova tutti i biglietti associati a questo pagamento
            'biglietti' => $bigliettoModel->where('pagamento_id', $pagamentoId)->findAll()
        ];
        
        // Da bismo dobili podatke o projekciji, moramo ih dohvatiti preko prvog biglietta
        if (!empty($data['biglietti'])) {
            $proiezioneModel = new \App\Models\Proiezione();
            $data['proiezione'] = $proiezioneModel->find($data['biglietti'][0]->proiezione_id);
        }

        return view('booking/success', $data);
    }

    /**
     * Genera un PDF di conferma per un dato pagamento.
     * @param int $pagamentoId ID del pagamento
     */
    public function generatePdf($pagamentoId)
    {
        $pagamentoModel = new Pagamento();
        $bigliettoModel = new Biglietto();
        $data = [
            'pagamento' => $pagamentoModel->find($pagamentoId),
            'biglietti' => $bigliettoModel->where('pagamento_id', $pagamentoId)->findAll()
        ];

        if (!empty($data['biglietti'])) {
            $proiezioneModel = new Proiezione();
            $data['proiezione'] = $proiezioneModel->find($data['biglietti'][0]->proiezione_id);
        }

        $html = view('booking/pdf_template', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("biglietti.pdf");
    }
}