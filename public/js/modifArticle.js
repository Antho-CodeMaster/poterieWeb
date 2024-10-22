document.addEventListener('DOMContentLoaded', function () {

    // Vérifie si on est sur la bonne page
    if (document.baseURI.includes("modifArticle")) {

        // Tableau pour stocker les clones du SVG initial
        let svgCache = [];

        function previewImage(event, index) {
            var fileInput = document.getElementById('photo' + index);
            var previewContainer = document.getElementById('previewContainer' + index);
            var deleteButton = document.getElementById('suppressionBtn' + index);
            var biggerContainer = document.getElementById('biggerContainer');

            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var existingImage = document.getElementById('imgPreview' + index);

                    if (existingImage) {
                        // Mettre à jour la source de l'image existante
                        existingImage.src = e.target.result;
                    } else {
                        // Créer une nouvelle image si elle n'existe pas encore
                        var img = document.createElement('img');
                        img.src = e.target.result; // Utiliser l'URL générée par FileReader
                        img.classList.add('w-[100px]', 'h-[96px]', 'object-cover', "border-[2px]", "border-darkGrey", "rounded-[0.375rem]");

                        // Remplacer le contenu du conteneur par l'image
                        previewContainer.innerHTML = '';
                        previewContainer.appendChild(img);
                        biggerContainer.appendChild(deleteButton);
                    }
                };

                reader.readAsDataURL(fileInput.files[0]); // Lire le fichier et générer l'URL temporaire
            }
        }

        // Fonction pour réinitialiser l'aperçu (remettre le SVG)
        function removeImage(index) {
            // Réinitialiser l'input file
            let fileInput = document.getElementById('photo' + index);
            fileInput.value = ''; // Réinitialise le champ de fichier sans le supprimer

            // Récupérer le conteneur d'aperçu et réinsérer le clone du SVG
            let previewContainer = document.getElementById('previewContainer' + index);
            let deleteButton = document.getElementById('suppressionBtn' + index);

            // Réinitialiser le contenu du conteneur et réinsérer le SVG cloné
            previewContainer.innerHTML = '';
            if (svgCache[index]) {
                previewContainer.innerHTML = svgCache[index];
            }
            previewContainer.appendChild(deleteButton); // Réinsérer le bouton de suppression
        }

        // Ajouter un gestionnaire d'événements 'change' pour chaque input file généré dans la boucle
        for (let i = 1; i <= 5; i++) {
            document.getElementById('photo' + i).addEventListener('change', function (event) {
                previewImage(event, i);
            });

            document.getElementById("suppressionBtn" + i).addEventListener("click", function (event) {
                removeImage(i);
            });

            let svgElement = document.getElementById('svg' + i);
            if (svgElement) {
                svgCache[i] = svgElement.outerHTML; // Stocker le SVG sous forme de string
            }
        }

        // Gestion de la quantité en fonction du type de pièce
        document.getElementById("pieceUnique").addEventListener("change", function (event) {
            quantiteByType(event);
        });
        window.addEventListener("load", function () {
            quantiteByType2();
        });

        let quantiteTampon;

        function quantiteByType(event) {
            let isUnique = document.getElementById("pieceUnique").value;
            let quantiteElement = document.getElementById("quantiteArticle");
            let titreQuantite = document.getElementById("titreQuantite");
            let infoQuantite = document.getElementById("infoQuantite");

            if (isUnique == 1) {
                quantiteElement.classList.add("hidden");
                titreQuantite.classList.add("hidden");
                infoQuantite.classList.add("hidden");
                quantiteTampon = quantiteElement.value;
                quantiteElement.value = 1;
            }
            else {
                quantiteElement.classList.remove("hidden");
                titreQuantite.classList.remove("hidden");
                infoQuantite.classList.remove("hidden");
                quantiteElement.value = quantiteTampon;
            }
        }

        function quantiteByType2(event) {
            let isUnique = document.getElementById("pieceUnique").value;
            let quantiteElement = document.getElementById("quantiteArticle");
            let titreQuantite = document.getElementById("titreQuantite");
            let infoQuantite = document.getElementById("infoQuantite");

            let quantiteValue = document.getElementById("quantiteArticle").value;

            if (isUnique == 1) {
                quantiteElement.classList.add("hidden");
                titreQuantite.classList.add("hidden");
                infoQuantite.classList.add("hidden");
                quantiteElement.value = 1;
            }
            else {
                quantiteElement.classList.remove("hidden");
                titreQuantite.classList.remove("hidden");
                infoQuantite.classList.remove("hidden");
                quantiteTampon = quantiteValue;
            }
        }
    }
});
