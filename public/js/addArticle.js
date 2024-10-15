document.addEventListener('DOMContentLoaded', function () {

    // Vérifie si on est sur la bonne page
    if (document.baseURI.includes("addArticleForm")) {

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

        // Gestion de la quantité en fonction du type de pièce
        document.getElementById("pieceUnique").addEventListener("change", function (event) {
            quantiteByType(event);
        });

        function quantiteByType(event) {
            let isUnique = document.getElementById("pieceUnique").value;
            let quantiteElement = document.getElementById("quantiteArticle");
            let titreQuantite = document.getElementById("titreQuantite");


            if (isUnique == 1) {
                quantiteElement.classList.add("hidden");
                titreQuantite.classList.add("hidden")
                quantiteElement.value = 1;
            }
            else {
                quantiteElement.classList.remove("hidden");
                titreQuantite.classList.remove("hidden")
                quantiteElement.value = "";
            }
        }
    }
});
