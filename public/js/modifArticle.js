document.addEventListener('DOMContentLoaded', function () {

    // Vérifie si on est sur la bonne page
    if (document.baseURI.includes("modifArticle")) {

/*         let svgCache = []; // Tableau pour stocker les clones du SVG initial */

        function previewImage(event, index) {
            var fileInput = document.getElementById('photo' + index);
            var previewContainer = document.getElementById('previewContainer' + index);

            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    // Recherchez une image d'aperçu existante
                    var existingImage = document.getElementById('imgPreview' + index);

                    if (existingImage) {
                        // Met à jour la source de l'image si elle existe déjà
                        existingImage.src = e.target.result;
                    } else {
                        // Crée une nouvelle image si elle n'existe pas
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.id = 'imgPreview' + index; // Ajout d'un ID unique
                        img.classList.add('w-[100px]', 'h-[96px]', 'object-cover', 'border-[2px]', 'border-darkGrey', 'rounded-[0.375rem]');

                        // Remplace uniquement le contenu du conteneur sans supprimer les autres éléments
                        previewContainer.innerHTML = '';
                        previewContainer.appendChild(img);
                    }
                };

                reader.readAsDataURL(fileInput.files[0]); // Lire le fichier comme URL temporaire
            }
        }

/*         // Fonction pour réinitialiser l'aperçu en remettant le SVG
        function removeImage(index) {
            let fileInput = document.getElementById('photo' + index);
            fileInput.value = ''; // Réinitialise le champ de fichier

            // Récupérer le conteneur d'aperçu
            let previewContainer = document.getElementById('previewContainer' + index);

            // Réinitialiser le contenu et réinsérer le SVG du cache
            previewContainer.innerHTML = '';
            if (svgCache[index]) {
                previewContainer.innerHTML = svgCache[index];
            }
        } */

        // Ajouter un gestionnaire d'événements 'change' pour chaque input file généré dans la boucle
        for (let i = 1; i <= 5; i++) {
            document.getElementById('photo' + i).addEventListener('change', function (event) {
                previewImage(event, i);
            });
/*
            document.getElementById("suppressionBtn" + i).addEventListener("click", function (event) {
                removeImage(i);
            }); */
/*
            // Sauvegarde du SVG d'origine dans le cache
            let svgElement = document.getElementById('svg' + i);
            if (svgElement) {
                svgCache[i] = svgElement.outerHTML;
            } */
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
