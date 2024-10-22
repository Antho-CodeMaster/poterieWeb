document.addEventListener('DOMContentLoaded', function () {

    // Vérifie si on est sur la bonne page
    if (document.baseURI.includes("modifArticle")) {

        function previewImage(event, index) {
            var fileInput = document.getElementById('photo' + index);
            var previewContainer = document.getElementById('previewContainer' + index);

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
                    }
                };

                reader.readAsDataURL(fileInput.files[0]); // Lire le fichier et générer l'URL temporaire
            }
        }

        // Ajouter un gestionnaire d'événements 'change' pour chaque input file généré dans la boucle
        for (let i = 1; i <= 5; i++) {
            document.getElementById('photo' + i).addEventListener('change', function (event) {
                previewImage(event, i);
            });
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
