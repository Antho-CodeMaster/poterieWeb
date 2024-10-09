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



        /* Fonctions pour gérer l'ajout des images de l'article déjà existant en input */


    }
});
