window.onload = () => {
    if (document.baseURI.includes("kiosque")) {

        /* Gestion du carrouselle */
        document.getElementById('nextBtn').addEventListener('click', function () {
            let carousel = document.getElementById('carousel');
            carousel.scrollBy({ left: 300, behavior: 'smooth' });
        });

        document.getElementById('prevBtn').addEventListener('click', function () {
            let carousel = document.getElementById('carousel');
            carousel.scrollBy({ left: -300, behavior: 'smooth' });
        });
    }
};

// Fonction de prévisualisation d'image
function previewImage(event, index) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function() {
        // Crée un élément <img> et remplace le SVG actuel
        var imgElement = document.createElement("img");
        imgElement.src = reader.result;
        imgElement.classList.add("w-full", "h-[150px]", "object-cover", "rounded-md"); // Ajout des classes CSS pour styliser l'image

        // Remplace le contenu du conteneur de prévisualisation
        var previewContainer = document.getElementById("previewContainer" + index);
        previewContainer.innerHTML = ''; // Efface le contenu actuel (le SVG ou bouton)
        previewContainer.appendChild(imgElement); // Ajoute l'image
    };

    // Vérifie si un fichier a été sélectionné
    if (input.files && input.files[0]) {
        // Lit le fichier sélectionné comme une URL de données
        reader.readAsDataURL(input.files[0]);
    }
}

