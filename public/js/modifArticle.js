document.addEventListener('DOMContentLoaded', function () {

    // Vérifie si on est sur la bonne page
    if (document.baseURI.includes("modifArticle")) {

        // Fonction qui va gérer l'aperçu de l'image
        function previewImage(event, index) {
            var fileInput = document.getElementById('photo' + index);
            var previewContainer = document.getElementById('previewContainer' + index);

            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    // Créer une balise img et remplacer le SVG
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('w-[100px]', 'h-[96px]', 'object-cover', "border-[2px]", "border-darkGrey", "rounded-[0.375rem]"); // Ajouter les classes CSS si nécessaire

                    // Remplacer le SVG par l'image
                    previewContainer.innerHTML = ''; // On vide le conteneur du SVG
                    previewContainer.appendChild(img); // Ajoute l'image téléversée
                }

                reader.readAsDataURL(fileInput.files[0]); // Lire le fichier comme une URL
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
