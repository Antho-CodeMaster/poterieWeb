document.addEventListener('DOMContentLoaded', function () {

    // Vérifie si on est sur la bonne page
    if (document.baseURI.includes("mesTransactions")) {
        /* ===================================================== */
        /*          Requête asynchrone pour les filtres          */
        /* ===================================================== */

        function applyFilter() {
            // Récupérer les éléments <select> pour les filtres
            const dateFilter = document.getElementById('dateFiltre');
            const compagnieFilter = document.getElementById('compagnieFiltre');
            const statutFilter = document.getElementById('statutFiltre');
            const searchTransaction = document.getElementById('searchTransaction');
            const idArtiste = document.getElementById('idArtiste');

            // Récupérer l'URL de la route pour le filtre depuis l'attribut `data-url`
            const routeFiltre = dateFilter.dataset.url;

            // Récupérer la valeur sélectionnée
            const dateFilterValue = dateFilter.value;
            const compagnieFilterValue = compagnieFilter.value;
            const statutFilterValue = statutFilter.value;
            const idArtisteValue = idArtiste.value;
            const searchTransactionValue = searchTransaction.value;

            console.clear();
            console.log("ROUTE:", routeFiltre);
            console.log("Date Filtre:", dateFilterValue);
            console.log("Compagnie Filter:", compagnieFilterValue);
            console.log("Statut Filter:", statutFilterValue);
            console.log("Search article:", searchTransactionValue);
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
                    compagnieFilter: compagnieFilterValue,
                    statutFilter: statutFilterValue,
                    searchTransaction: searchTransactionValue,
                    idArtiste: idArtisteValue
                })
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Une erreur est survenue lors de la requête');
                }
                return response.json();
            }).then(data => {
                if (data.status === 'success') {
                    document.getElementById('commandesContainer').innerHTML = data.html; // Met à jour le conteneur des articles
                    console.log(data.commandeTransactions)
                } else {
                    console.error("Échec de l'application du filtre");
                    console.log(data.message)
                }
            }).catch(error => console.error('Erreur:', error));
        }

        // Ajouter un écouteur pour déclencher `applyFilter` lors d'un changement de sélection
        document.getElementById('dateFiltre').addEventListener('change', applyFilter);
        document.getElementById('compagnieFiltre').addEventListener('change', applyFilter);
        document.getElementById('statutFiltre').addEventListener('change', applyFilter);
        document.getElementById('searchTransaction').addEventListener('input', applyFilter);

        /* ===================================================== */
        /*      Requête asynchrone pour effacer les filtres      */
        /* ===================================================== */

        document.getElementById('clearFiltre').addEventListener('click', clearFilter);

        function clearFilter() {
            // Récupérer les éléments <select> pour les filtres
            const dateFilter = document.getElementById('dateFiltre');
            const compagnieFilter = document.getElementById('compagnieFiltre');
            const statutFilter = document.getElementById('statutFiltre');
            const searchTransaction = document.getElementById('searchTransaction');
            const idArtiste = document.getElementById('idArtiste');

            // Récupérer l'URL de la route pour le filtre depuis l'attribut `data-url`
            const routeFiltre = dateFilter.dataset.url;

            // Récupérer la valeur sélectionnée
            const dateFilterValue = dateFilter.value = '1';
            const compagnieFilterValue = compagnieFilter.value = 'null';
            const statutFilterValue = statutFilter.value = 'null';
            const idArtisteValue = idArtiste.value;
            const searchTransactionValue = searchTransaction.value = '';

            console.clear();
            console.log("ROUTE:", routeFiltre);
            console.log("Date Filtre:", dateFilterValue);
            console.log("Compagnie Filter:", compagnieFilterValue);
            console.log("Statut Filter:", statutFilterValue);
            console.log("Search article:", searchTransactionValue);
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
                    compagnieFilter: compagnieFilterValue,
                    statutFilter: statutFilterValue,
                    searchTransaction: searchTransactionValue,
                    idArtiste: idArtisteValue
                })
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Une erreur est survenue lors de la requête');
                }
                return response.json();
            }).then(data => {
                if (data.status === 'success') {
                    document.getElementById('commandesContainer').innerHTML = data.html; // Met à jour le conteneur des articles
                    console.log(data.commandeTransactions)
                } else {
                    console.error("Échec de l'application du filtre");
                    console.log(data.message)
                }
            }).catch(error => console.error('Erreur:', error));
        }
    }
});
