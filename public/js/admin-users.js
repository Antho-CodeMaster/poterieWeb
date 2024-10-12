if (document.baseURI.includes('admin/utilisateurs')) {
    let users = document.getElementsByClassName("user");
    let searchButton = document.querySelector("#search-user button");
    let selectType = document.getElementById("type");

    searchButton.addEventListener("click", filter);

    selectType.addEventListener("change", filter);

    function filter() {
        let search = document.querySelector("#search-user input").value; //Contenu de la barre de recherche
        let type = selectType.value;                                //Type d'utilisateur sélectionné
        let cpt = 0;                                                // Compteur d'utilisateurs affichés
        let resultCount = document.getElementsByTagName("h2")[0];   // Balise dans laquelle mettre à jour le nombre d'utilisateurs affichés
        let resultats = "";                                         // Cette string affichera "résultat" si 1 user, "résultats" si plusieurs users

        for (let i = 0; i < users.length; i++) {
            let user_name = users[i].firstChild.nextElementSibling.firstChild.nextElementSibling.innerHTML; // Nom de l'utilisateur
            let user_type = users[i].firstChild.nextElementSibling.firstChild.nextElementSibling.nextElementSibling.innerHTML; // Type d'utilisateur
            // Il faut vérifier que le type soit celui sélectionné.
            // Ensuite, il faut vérifier si le nom d'utilisateur inclut la string mise tans la recherche, puis mettre ces deux filtres ensemble avec un ET.
            if (
                (
                    (type == "tous") || // Si on veut afficher tous les utilisateurs
                    (user_type.toUpperCase() == type.toUpperCase()) || //Si le type de l'utilisateur est égal à celui du filtre
                    (type == "Administration" && (user_type == "Modérateur" || user_type == "Administrateur")) // Si le type choisi est Administration, on veut afficher Modérateurs et administrateurs
                ) && // Et on veut aussi que la recherche fonctionne:
                user_name.toUpperCase().includes(search.toUpperCase())) {
                cpt++; // Un utilisateur de plus sera affiché
                users[i].classList.remove('hidden'); // S'il était caché, il ne le sera plus
            } else users[i].classList.add('hidden'); // Si une des conditions n'est pas respectée, cacher l'utilisateur
        }

        cpt == 1 ? resultats = " résultat" : resultats = " résultats";

        resultCount.innerHTML = cpt + resultats;
    }

    filter();

    // Rendre le bouton rouge et actif si on entre le bon nom d'utilisateur pour pouvoir le supprimer

    let deleteUserName = document.getElementById("deleteUsername");
    let validateInput = document.getElementById("validateInput");
    let deleteButton = document.getElementById("deleteButton");
    let deleteSVG = document.getElementById("deleteSVG");
    let deleteP = document.getElementById("deleteP");

    validateInput.addEventListener('input', validateDelete);

    function validateDelete(evt) {
        if (deleteUserName.innerHTML == evt.target.value) {
            deleteButton.disabled = false;
            deleteButton.classList.add("bg-[#FA3D3D]");
            deleteButton.classList.add("hover:bg-[#FF0000]");
            deleteButton.classList.remove("bg-darkGrey");
            deleteButton.classList.remove("hover:bg-darkGrey");
            deleteSVG.stroke = "#FFFFFF"
            deleteP.classList.add("text-[#FFBEBE]");
            deleteP.classList.remove("text-white");
        }
        else {
            deleteButton.disabled = true;
            deleteButton.classList.remove("bg-[#FA3D3D]");
            deleteButton.classList.remove("hover:bg-[#FF0000]");
            deleteButton.classList.add("bg-darkGrey");
            deleteButton.classList.add("hover:bg-darkGrey");
            deleteSVG.stroke = "#FFFFFF"
            deleteP.classList.add("text-white");
            deleteP.classList.remove("text-[#FFBEBE]");
        }

    }

    // S'assurer que le bouton ne soit pas activé si on ferme le modal

    let closeModal = document.getElementById("closeModal");

    closeModal.addEventListener("click", function () {
        validateInput.value = "";
        deleteButton.disabled = true;
        deleteButton.classList.remove("bg-[#FA3D3D]");
        deleteButton.classList.remove("hover:bg-[#FF0000]");
        deleteButton.classList.add("bg-darkGrey");
        deleteButton.classList.add("hover:bg-darkGrey");
        deleteSVG.stroke = "#FFFFFF"
        deleteP.classList.add("text-white");
        deleteP.classList.remove("text-[#FFBEBE]");
    });
}

