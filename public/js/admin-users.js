let users = document.getElementsByClassName("user");
let searchButton = document.querySelector("#search-user button");
let selectType = document.getElementById("type");

searchButton.addEventListener("click", filter);

selectType.addEventListener("change", filter);

function filter()
{
    let search = document.querySelector("#search-user input").value; //Contenu de la barre de recherche
    let type = selectType.value;                                //Type d'utilisateur sélectionné
    let cpt = 0;                                                // Compteur d'utilisateurs affichés
    let resultCount = document.getElementsByTagName("h2")[0];   // Balise dans laquelle mettre à jour le nombre d'utilisateurs affichés
    let resultats = "";                                         // Cette string affichera "résultat" si 1 user, "résultats" si plusieurs users

    for(let i = 0; i < users.length; i++){
        let user_name = users[i].firstChild.nextElementSibling.firstChild.nextElementSibling.innerHTML; // Nom de l'utilisateur
        let user_type = users[i].firstChild.nextElementSibling.firstChild.nextElementSibling.nextElementSibling.innerHTML; // Type d'utilisateur
        // Si type == tous, le filtre de type est validé. Sinon, il faut vérifier que le type soit celui sélectionné.
        // Ensuite, il faut vérifier si le nom d'utilisateur inclut la string mise tans la recherche, puis mettre ces deux filtres ensemble avec un ET.
        if ((type == "tous" || user_type.toUpperCase() == type.toUpperCase()) &&
         user_name.toUpperCase().includes(search.toUpperCase())) {
            cpt++; // Un utilisateur de plus sera affiché
            users[i].classList.remove('hidden'); // S'il était caché, il ne le sera plus
        } else users[i].classList.add('hidden'); // Si une des conditions n'est pas respectée, cacher l'utilisateur
    }

    cpt == 1 ? resultats = " résultat" : resultats = " résultats";

    resultCount.innerHTML = cpt + resultats;
}
