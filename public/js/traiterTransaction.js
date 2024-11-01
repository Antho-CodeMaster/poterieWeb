document.addEventListener('DOMContentLoaded', function () {

    // Vérifie si on est sur la bonne page
    if (document.baseURI.includes("traiterTransactionForm")) {

        // Fonction pour gérer l'aperçu de l'image
        function previewImage(event, index) {
            var fileInput = document.getElementById('photo' + index);
            var previewContainer = document.getElementById('previewContainer' + index);
            var deleteButton = document.getElementById('suppressionBtn' + index);

            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    // Créer une balise img et remplacer le SVG
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('w-[200px]', 'h-[190px]', 'object-cover', "border-[2px]", "border-darkGrey", "rounded-[0.5rem]");

                    // Remplacer le SVG par l'image
                    previewContainer.innerHTML = ''; // Vider le conteneur du SVG
                    previewContainer.appendChild(img); // Ajouter l'image téléversée
                    previewContainer.appendChild(deleteButton);
                }

                reader.readAsDataURL(fileInput.files[0]); // Lire le fichier comme une URL
            }
        }

        // Fonction pour réinitialiser l'aperçu (remettre le SVG)
        function removeImage(index) {
            let fileInput = document.getElementById('photo' + index);
            fileInput.value = ''; // Réinitialiser le champ de fichier

            // Récupérer le conteneur d'aperçu
            let previewContainer = document.getElementById('previewContainer' + index);
            let deleteButton = document.getElementById('suppressionBtn' + index);

            // Créer une nouvelle instance du SVG en le clonant
            let svgClone = boutonsInputClone[index].cloneNode(true);

            // Remplacer le contenu du conteneur et ajouter le SVG cloné
            previewContainer.innerHTML = '';
            previewContainer.appendChild(svgClone); // Ajouter un nouveau clone du SVG
            previewContainer.appendChild(deleteButton); // Réinsérer le bouton de suppression
        }

        // Stocker chaque bouton SVG original
        let boutonsInputClone = [];
        for (let i = 1; i <= 3; i++) {
            boutonsInputClone[i] = document.getElementById('boutonInput' + i).cloneNode(true);

            // Ajouter un gestionnaire d'événements 'change' pour chaque input file généré dans la boucle
            document.getElementById('photo' + i).addEventListener('change', function (event) {
                previewImage(event, i);
            });

            document.getElementById("suppressionBtn" + i).addEventListener("click", function (event) {
                removeImage(i);
            });
        }
    }
});
