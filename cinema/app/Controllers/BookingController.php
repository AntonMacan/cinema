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
 * Processa la selezione dei biglietti, crea il pagamento, salva i biglietti,
 * e invia un'email di conferma con il PDF in allegato.
 */
public function process()
{
    // 1. Controlla se l'utente è loggato (ostaje isto)
    if (!session()->get('isLoggedIn')) {
        session()->set('redirect_url', previous_url());
        return redirect()->to('/login')->with('error', 'Devi effettuare il login per acquistare i biglietti.');
    }

    // Recupera i dati dal form (ostaje isto)
    $proiezioneId = $this->request->getPost('proiezione_id');
    $bigliettiSelezionati = $this->request->getPost('biglietti');
    $tipi_biglietti_info = [
        'intero' => ['tipo' => 'Intero', 'prezzo' => 10.00],
        'ridotto' => ['tipo' => 'Ridotto', 'prezzo' => 7.50]
    ];

    $bigliettiDaSalvare = [];
    $importoTotale = 0.00;

    // Calcola il prezzo totale e prepara i dati per ogni biglietto
    foreach ($bigliettiSelezionati as $key => $quantita) {
        // Provjera da je količina ispravan broj i veći od 0
        if (is_numeric($quantita) && $quantita > 0) {

            // For petlja koja osigurava da se cijena samo zbraja, bez množenja
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

    if (empty($bigliettiDaSalvare)) {
        return redirect()->back()->with('error', 'Devi selezionare almeno un biglietto.');
    }

    // 3. Crea il record di pagamento (ostaje isto)
    $pagamentoModel = new Pagamento();
    $pagamentoData = [
        'cliente_id' => session()->get('user_id'),
        'importo' => $importoTotale,
        'metodo_pagamento' => 'Online (Simulato)',
        'stato_transazione' => 'completato'
    ];
    $pagamentoModel->save($pagamentoData);
    $pagamentoId = $pagamentoModel->getInsertID();

    // 4. Aggiungi l'ID del pagamento a ogni biglietto e salvali (ostaje isto)
    foreach ($bigliettiDaSalvare as &$biglietto) {
        $biglietto['pagamento_id'] = $pagamentoId;
    }
    $bigliettoModel = new Biglietto();
    $bigliettoModel->insertBatch($bigliettiDaSalvare);

    $dataPerEmail = [
        'pagamento' => $pagamentoModel->find($pagamentoId),
        'biglietti' => $bigliettoModel->where('pagamento_id', $pagamentoId)->findAll(),
        'proiezione' => (new Proiezione())->find($proiezioneId)
    ];

    $pdfHtml = view('booking/pdf_template', $dataPerEmail);
    $dompdf = new Dompdf();
    $dompdf->loadHtml($pdfHtml);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $pdfOutput = $dompdf->output();
 
    $email = \Config\Services::email();
    $email->setTo(session()->get('email'));
    $email->setFrom('info@cinema-teatro.com', 'Cinema-Teatro');
    $email->setSubject('Conferma di Prenotazione - Cinema-Teatro');

    $emailMessage = view('emails/ticket_confirmation', $dataPerEmail); 
    $email->setMessage($emailMessage);

    $email->attach($pdfOutput, 'attachment', 'biglietti' . $pagamentoId . '.pdf', 'application/pdf');

    if (!$email->send(false)) {
        log_message('error', $email->printDebugger(['headers']));
    }

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