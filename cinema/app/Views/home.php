<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Cine-Teatro
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <h1>Adesso al cinema</h1>
    <p>Film e spettacoli nei prossimi 7 giorni</p>

    <div class="film-gallery">
        <?php if (!empty($films_e_spettacoli)): ?>
            <?php foreach ($films_e_spettacoli as $item): ?>
                <div class="film-card">
                    <?php 
                        $contenuto = $item['contenuto'];
                        $tipo = $item['tipo'];
                        $link_dettagli = '/' . $tipo . '/' . $contenuto->id;
                    ?>
                    <a href="<?= $link_dettagli ?>">
                        <img src="/uploads/posters/<?= esc($contenuto->poster ?? 'default.jpg') ?>" alt="<?= esc($contenuto->titolo) ?>" class="film-poster">
                    </a>
                        <h3><a href="<?= $link_dettagli ?>"><?= esc($contenuto->titolo) ?></a></h3>
                        <div class="termini">
                            
                                <div class="termini-day">
                                    <strong>Oggi:</strong>
                                    <?php if (!empty($item['proiezioni_oggi'])): ?>
                                    <?php foreach ($item['proiezioni_oggi'] as $proiezione): ?>
                                        <a href="/reservation/<?= $proiezione->id ?>" class="termin-link"><?= date('H:i', strtotime($proiezione->orario)) ?></a>
                                    <?php endforeach; ?>
                                     <?php endif; ?>
                                </div>
                                <div class="termini-day">
                                    <strong>Domani:</strong>
                                     <?php if (!empty($item['proiezioni_domani'])): ?>
                                    <?php foreach ($item['proiezioni_domani'] as $proiezione): ?>
                                        <a href="/reservation/<?= $proiezione->id ?>" class="termin-link"><?= date('H:i', strtotime($proiezione->orario)) ?></a>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            
                        </div>
                    </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Non ce niente al cinema.</p>
        <?php endif; ?>
    </div>

    <hr style="margin-top: 40px;">

<div class="filters-section">
    <h2>Dettaglio del Programma</h2>
    <div class="filters">
        <div class="form-group">
            <label for="filter-date">Filtra per Data</label>
            <input type="date" id="filter-date" value="<?= esc($dataOggi, 'attr') ?>" min="<?= esc($dataOggi, 'attr') ?>">
        </div>
        <div class="form-group">
            <label for="filter-title">Cerca per Titolo</label>
            <input type="text" id="filter-title" placeholder="Scrivi il titolo...">
        </div>
    </div>
</div>

<ul id="full-schedule-list" style="list-style: none; padding: 0;">
    <?php foreach ($tutte_le_proiezioni as $proiezione): ?>
        <?php $contenuto = $proiezione->getFilm() ?? $proiezione->getSpettacolo(); ?>
        <?php if (!$contenuto) continue; ?>

        <li class="schedule-item" data-date="<?= $proiezione->data ?>" data-title="<?= strtolower(esc($contenuto->titolo)) ?>">
            <div>
                <span style="font-size: 0.9em; color: #555;"><?= date('d.m.Y, l', strtotime($proiezione->data)) ?></span><br>
                <a href="/<?= ($proiezione->film_id ? 'film' : 'spettacolo') ?>/<?= $contenuto->id ?>" class="content-title"><?= esc($contenuto->titolo) ?></a>
            </div>
            <div class="content-time">
                <a href="/reservation/<?= $proiezione->id ?>" class="termin-link">
                    <?= esc(date('H:i', strtotime($proiezione->orario))) ?>h
                </a>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
<script>
    // Dohvaćamo elemente iz HTML-a
    const dateFilter = document.getElementById('filter-date');
    const titleFilter = document.getElementById('filter-title');
    const scheduleList = document.querySelectorAll('.schedule-item');

    // Funkcija koja će se pozvati svaki put kad se promijeni filter
    function filterProjections() {
        const selectedDate = dateFilter.value; // npr. "2025-07-01"
        const searchTitle = titleFilter.value.toLowerCase(); // sve pretvaramo u mala slova

        // Prolazimo kroz svaku stavku u listi
        scheduleList.forEach(item => {
            const itemDate = item.dataset.date;
            const itemTitle = item.dataset.title;

            // Provjeravamo podudaranje
            const dateMatch = (selectedDate === '') || (itemDate === selectedDate);
            const titleMatch = itemTitle.includes(searchTitle);

            // Ako stavka zadovoljava OBA filtera, prikaži je, inače je sakrij
            if (dateMatch && titleMatch) {
                item.style.display = 'flex'; // 'flex' jer smo tako stilizirali li elemente
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Dodajemo "slušatelje" na oba input polja
    dateFilter.addEventListener('change', filterProjections);
    titleFilter.addEventListener('keyup', filterProjections); // 'keyup' reagira na svako pritisnuto slovo
    filterProjections();
</script>
<?= $this->endSection() ?>