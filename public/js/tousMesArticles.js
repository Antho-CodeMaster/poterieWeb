document.addEventListener('DOMContentLoaded', function () {

    // Vérifie si on est sur la bonne page
    if (document.baseURI.includes("tousMesArticles")) {

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
            const masqueFilter = document.getElementById('masqueFiltre');
            const vedetteFilter = document.getElementById('vedetteFiltre');
            const sensibleFilter = document.getElementById('sensibleFiltre');

            const searchArticle = document.getElementById('searchArticle');

            // Récupérer l'URL de la route pour le filtre depuis l'attribut `data-url`
            const routeFiltre = dateFilter.dataset.url;

            // Récupérer la valeur sélectionnée
            const dateFilterValue = dateFilter.value;
            const usageFilterValue = usageFilter.value;
            const pieceFilterValue = pieceFilter.value;
            const prixMinFilterValue = prixMinFilter.value;
            const prixMaxFilterValue = prixMaxFilter.value;
            const masqueFilterValue = masqueFilter.value;
            const vedetteFilterValue = vedetteFilter.value;
            const sensibleFilterValue = sensibleFilter.value;

            const searchArticleValue = searchArticle.value;

            console.clear();
            console.log("Date Filtre:", dateFilterValue);
            console.log("Usage Filter:", usageFilterValue);
            console.log("Piece Filter:", pieceFilterValue);
            console.log("Prix Min Filter:", prixMinFilterValue);
            console.log("Prix Max Filter:", prixMaxFilterValue);
            console.log("Masque Filter:", masqueFilterValue);
            console.log("Vedette Filter:", vedetteFilterValue);
            console.log("Sensible Filter:", sensibleFilterValue);
            console.log("Search article:", searchArticleValue);

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
                    masqueFilter: masqueFilterValue,
                    vedetteFilter: vedetteFilterValue,
                    sensibleFilter: sensibleFilterValue,
                    searchArticle: searchArticleValue
                })
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Une erreur est survenue lors de la requête');
                }
                return response.json();
            }).then(data => {
                if (data.status === 'success') {
                    document.getElementById('articlesContainer').innerHTML = data.html; // Met à jour le conteneur des articles
                    console.log(data.dateFiltre);
                } else {
                    console.error("Échec de l'application du filtre");
                }
            }).catch(error => console.error('Erreur:', error));
        }

        // Ajouter un écouteur pour déclencher `applyFilter` lors d'un changement de sélection
        document.getElementById('dateFiltre').addEventListener('change', applyFilter);
        document.getElementById('typePieceFiltre').addEventListener('change', applyFilter);
        document.getElementById('pieceUniqueFiltre').addEventListener('change', applyFilter);
        document.getElementById('prixFiltreMin').addEventListener('input', applyFilter);
        document.getElementById('prixFiltreMax').addEventListener('input', applyFilter);
        document.getElementById('masqueFiltre').addEventListener('change', applyFilter);
        document.getElementById('vedetteFiltre').addEventListener('change', applyFilter);
        document.getElementById('sensibleFiltre').addEventListener('change', applyFilter);
        document.getElementById('searchArticle').addEventListener('input', applyFilter);
    };
})
