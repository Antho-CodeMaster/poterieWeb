document.addEventListener('DOMContentLoaded', function () {
    if (document.baseURI.includes("kiosque")) {

        let closeWelcome = document.getElementById("closeWelcomeModal");

        if (closeWelcome != null) {
            closeWelcome.addEventListener("click", function () {
                document.getElementById("welcomeModal").classList.add("hidden");
            })
        }

        /* Gestion du carrouselle */
        document.getElementById('nextBtn').addEventListener('click', function () {
            let carousel = document.getElementById('carousel');
            carousel.scrollBy({ left: 300, behavior: 'smooth' });
        });

        document.getElementById('prevBtn').addEventListener('click', function () {
            let carousel = document.getElementById('carousel');
            carousel.scrollBy({ left: -300, behavior: 'smooth' });
        });

        /* ===================================================== */
        /*             caché ou apparaite les filtres            */
        /* ===================================================== */
        const btnFiltres = document.getElementById('btnFiltres');
        const kiosqueFiltres = document.getElementById('kiosqueFiltres');
        // Gestion du clic sur le bouton pour ouvrir/fermer les filtres

        btnFiltres.addEventListener("click", (event) => {
            event.stopPropagation(); // Empêche la propagation de l'événement au document
            toggleFiltres();
        });

        // Gestion du clic en dehors du conteneur pour fermer les filtres
        document.addEventListener("click", (event) => {
            // Vérifie si les filtres sont ouverts et si le clic est en dehors du conteneur
            if (kiosqueFiltres.classList.contains('visible') &&
                !kiosqueFiltres.contains(event.target)) {
                toggleFiltres(); // Ferme les filtres
            }
        });

        function toggleFiltres() {
            const kiosqueFiltres = document.getElementById('kiosqueFiltres');

            if (kiosqueFiltres.classList.contains('opacity-0')) {
                // Rendre visible
                kiosqueFiltres.classList.remove('opacity-0', 'invisible');
                kiosqueFiltres.classList.add('opacity-100', 'visible');
            } else {
                // Rendre invisible
                kiosqueFiltres.classList.remove('opacity-100', 'visible');
                kiosqueFiltres.classList.add('opacity-0', 'invisible');
            }
        }


        /* ===================================================== */
        /*          Requête asynchrone pour les filtres          */
        /* ===================================================== */

        function applyFilter() {
            // Récupérer les éléments <select> pour les filtres
            const dateFilter = document.getElementById('dateFiltre');
            const usageFilter = document.getElementById('typePieceFiltre');
            const pieceFilter = document.getElementById('pieceUniqueFiltre');
            const prixMinFilter = document.getElementById('prixFiltreMin');
            const prixMaxFilter = document.getElementById('prixFiltreMax');
            const searchArticle = document.getElementById('searchArticle');
            const idArtiste = document.getElementById('idArtiste');

            // Récupérer l'URL de la route pour le filtre depuis l'attribut `data-url`
            const routeFiltre = dateFilter.dataset.url;

            // Récupérer la valeur sélectionnée
            const dateFilterValue = dateFilter.value;
            const usageFilterValue = usageFilter.value;
            const pieceFilterValue = pieceFilter.value;
            const prixMinFilterValue = prixMinFilter.value;
            const prixMaxFilterValue = prixMaxFilter.value;
            const idArtisteValue = idArtiste.value;

            const searchArticleValue = searchArticle.value;

            console.clear();
            console.log("ROUTE:", routeFiltre);
            console.log("Date Filtre:", dateFilterValue);
            console.log("Usage Filter:", usageFilterValue);
            console.log("Piece Filter:", pieceFilterValue);
            console.log("Prix Min Filter:", prixMinFilterValue);
            console.log("Prix Max Filter:", prixMaxFilterValue);
            console.log("Search article:", searchArticleValue);
            console.log("idArtiste:", idArtisteValue);

            // Faire la requête asynchrone pour appliquer le filtre
            fetch(routeFiltre, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                body: JSON.stringify({
                    dateFilter: dateFilterValue,
                    usageFilter: usageFilterValue,
                    pieceFilter: pieceFilterValue,
                    prixMinFilter: prixMinFilterValue,
                    prixMaxFilter: prixMaxFilterValue,
                    searchArticle: searchArticleValue,
                    idArtiste: idArtisteValue
                })
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Une erreur est survenue lors de la requête');
                }
                return response.json();
            }).then(data => {
                if (data.status === 'success') {
                    document.getElementById('articlesContainer').innerHTML = data.html; // Met à jour le conteneur des articles
                    Alpine.initTree(document.getElementById('articlesContainer'));
                } else {
                    console.error("Échec de l'application du filtre");
                    console.log(data.message)
                }
            }).catch(error => console.error('Erreur:', error));
        }

        // Ajouter un écouteur pour déclencher `applyFilter` lors d'un changement de sélection
        document.getElementById('dateFiltre').addEventListener('change', applyFilter);
        document.getElementById('typePieceFiltre').addEventListener('change', applyFilter);
        document.getElementById('pieceUniqueFiltre').addEventListener('change', applyFilter);
        document.getElementById('prixFiltreMin').addEventListener('change', applyFilter);
        document.getElementById('prixFiltreMax').addEventListener('change', applyFilter);
        document.getElementById('searchArticle').addEventListener('input', applyFilter);

        /* ===================================================== */
        /*      Requête asynchrone pour effacer les filtres      */
        /* ===================================================== */

        document.getElementById('clearFiltre').addEventListener('click', clearFilter);

        function clearFilter() {
            // Récupérer les éléments <select> pour les filtres
            const dateFilter = document.getElementById('dateFiltre');
            const usageFilter = document.getElementById('typePieceFiltre');
            const pieceFilter = document.getElementById('pieceUniqueFiltre');
            const prixMinFilter = document.getElementById('prixFiltreMin');
            const prixMaxFilter = document.getElementById('prixFiltreMax');
            const searchArticle = document.getElementById('searchArticle');
            const idArtiste = document.getElementById('idArtiste');

            // Récupérer l'URL de la route pour le filtre depuis l'attribut `data-url`
            const routeFiltre = dateFilter.dataset.url;

            // Récupérer la valeur sélectionnée
            const dateFilterValue = dateFilter.value = '1';
            const usageFilterValue = usageFilter.value = 'null';
            const pieceFilterValue = pieceFilter.value = 'null';
            const prixMinFilterValue = prixMinFilter.value = '';
            const prixMaxFilterValue = prixMaxFilter.value = '';
            const idArtisteValue = idArtiste.value;

            const searchArticleValue = searchArticle.value = '';

            console.clear();
            console.log("ROUTE:", routeFiltre);
            console.log("Date Filtre:", dateFilterValue);
            console.log("Usage Filter:", usageFilterValue);
            console.log("Piece Filter:", pieceFilterValue);
            console.log("Prix Min Filter:", prixMinFilterValue);
            console.log("Prix Max Filter:", prixMaxFilterValue);
            console.log("Search article:", searchArticleValue);
            console.log("idArtiste:", idArtisteValue);

            // Faire la requête asynchrone pour appliquer le filtre
            fetch(routeFiltre, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                body: JSON.stringify({
                    dateFilter: dateFilterValue,
                    usageFilter: usageFilterValue,
                    pieceFilter: pieceFilterValue,
                    prixMinFilter: prixMinFilterValue,
                    prixMaxFilter: prixMaxFilterValue,
                    searchArticle: searchArticleValue,
                    idArtiste: idArtisteValue
                })
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Une erreur est survenue lors de la requête');
                }
                return response.json();
            }).then(data => {
                if (data.status === 'success') {
                    document.getElementById('articlesContainer').innerHTML = data.html; // Met à jour le conteneur des articles
                    Alpine.initTree(document.getElementById('articlesContainer'));
                } else {
                    console.error("Échec de l'application du filtre");
                }
            }).catch(error => console.error('Erreur:', error));
        }
    }
});

