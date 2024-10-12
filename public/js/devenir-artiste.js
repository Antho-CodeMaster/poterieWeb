if (document.baseURI.includes('devenir-artiste')) {
    displayAddedImagesIdentite(document.getElementById('photo-identite'));


    /************************************************************************************/
    /* Changer la section affichée si l'utilisateur veut être étudiant VS professionnel */
    /************************************************************************************/
    let select = document.getElementsByTagName("select")[0];

    select.addEventListener('change', switchMessage);
    switchMessage(select);

    function switchMessage(evt) {
        // Si appel vient d'un eventListener
        let select = evt.target;

        // Si appel vient de la suppression d'image (plus bas), le input est passé en paramètre mais n'est pas un évènement
        if(!select)
            select = evt;

        if (select.value == "etu") {
            document.getElementById("variable-message-pro").classList.add("hidden");
            document.getElementById("variable-message-etu").classList.remove("hidden");
        }
        else if (select.value == "pro") {
            document.getElementById("variable-message-etu").classList.add("hidden");
            document.getElementById("variable-message-pro").classList.remove("hidden");
        }
    }

    /************************************************************************************/
    /* Afficher une bulle d'information sur les rôles (étudiants, professionnels)       */
    /************************************************************************************/

    let info = document.getElementById("info");
    info.addEventListener("mouseenter", function(){
        document.getElementById("infobubble").classList.remove("hidden");
    });
    info.addEventListener("mouseleave", function(){
        document.getElementById("infobubble").classList.add("hidden");
    });

    /************************************************************************************/
    /*                          GESTION DES PHOTOS DE PREUVE                            */
    /************************************************************************************/

    /************************************************************************************/
    /* Mettre les photos dans la balise "input", sinon afficher un message d'erreur     */
    /************************************************************************************/

    document.getElementById("add-photo-preuve").addEventListener('click', function () {
        // Itérer dans les espaces du tableau de fichiers du input
        for (let i = 0; i < 10; i++) {
            // Si un emplacement est vide, on peut procéder à l'ajout des fichiers (plus de gestion d'erreurs est faite dans la fonction addImages())
            if (!document.getElementById('photo-preuve').files[i]) {
                addImages();
                // Une fois l'ajout fait, on peut quitter.
                return;
            }
        }
        // Si on a pas rencontré la condition "IF", c'est que les 10 emplacements sont occupés et qu'on essaie d'ajouter des images. On doit donc afficher le message d'erreur.
        document.getElementById('nb-photo-msg').classList.add("text-red-500", "font-bold");
    });

    /************************************************************************************/
    /* Si on ajoute une image, afficher son nom dans la liste (ces balises sont déjà    */
    /* faites dans le HTML, on fait juste les afficher au besoin)                       */
    /************************************************************************************/

    document.getElementById('photo-preuve').addEventListener('change', displayAddedImages);

    /************************************************************************************/
    /* Cette fonction fait en sorte que l'utilisateur peut ajouter des images à l'aide  */
    /* d'un input, dans pour autant les remplacer comme l'input ferait normalement.     */
    /************************************************************************************/
    function addImages() {
        const input = document.getElementById('photo-preuve');
        const dt = new DataTransfer();
        const existingFiles = input.files;

        // Ajouter les fichiers déjà ajoutés dans "input" à la liste du DataTransfer
        for (let i = 0; i < existingFiles.length; i++)
            dt.items.add(existingFiles[i]);

        // Créer un "input" temporaire pour que l'utilisateur puisse ajouter de nouvelles photos
        const newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.multiple = true;
        newInput.accept="image/jpeg, image/jpg, image/png"

        // Ajouter un EventListener une fois que l'utilisateur a mis ses images pour traiter les changements
        newInput.onchange = function(event) {
            const newFiles = event.target.files;

            // Si les nouveaux fichiers et les anciens dépassent 10, afficher le message d'erreur et ignorer les entrées
            if(dt.items.length + newFiles.length > 10)
                document.getElementById('nb-photo-msg').classList.add("text-red-500", "font-bold");

            // Si on est en dessous ou égal à 5, procéder à l'ajout des nouvelles images
            else
            {
                // Effacer le message d'erreur
                document.getElementById('nb-photo-msg').classList.remove("text-red-500", "font-bold");

                // Ajout des images à l'objet DataTransfer
                for (let i = 0; i < newFiles.length; i++)
                    if(dt.items.length <= 10)
                        dt.items.add(newFiles[i]);
            }

            // Assigner les nouvelles images
            input.files = dt.files;
            displayAddedImages(input);
        };

        // Une fois le EventListener ajouté, trigger l'objet pour que l'utilisateur ajoute des images
        newInput.click();
    };

    /************************************************************************************/
    /* Cette fonction fait en sorte que les images ajoutées sont affichées dans une     */
    /* liste afin que l'utilisateur puisse voir quelles images ont été sélectionnées et */
    /* les supprimer au besoin.                                                         */
    /************************************************************************************/

    function displayAddedImages(evt){
        // Si appel vient d'un eventListener
        let input = evt.target;

        // Si appel vient de la suppression d'image (plus bas), le input est passé en paramètre mais n'est pas un évènement
        if(!input)
            input = evt;

        // Liste de fichiers
        let files = input.files;

        // Pour 10 fichiers maximum
        for (let i = 0; i < 10; i++)
        {
            // Si le fichier existe, afficher la zone prévue à cet effet et changer le texte interne pour le nom du fichier
            if (files[i]) {
                document.getElementById("img-" + i).classList.remove("hidden");
                document.getElementById("img-" + i).classList.add("flex");
                document.getElementById("img-" + i).firstChild.nextSibling.innerHTML = files[i].name;
            }
        }
    }

    /************************************************************************************/
    /* Gestion de la suppression d'images de la liste (si l'utilisateur clique sur le X)*/
    /************************************************************************************/

    // Pour chacune des 10 images, ajout du EventListener
    for (let i = 0; i < 10; i++)
    {
        // Cette fonction fera en sorte que les images seront décalées d'un emplacement si une image précédente est supprimée du tableau.
        document.getElementById('remove-img-' + i).addEventListener('click', function (){

            // Supprimer le message d'erreur s'il était affiché, car l'utilisateur a compris qu'il essaie d'envoyer trop d'images.
            document.getElementById('nb-photo-msg').classList.remove("text-red-500", "font-bold");

            const input = document.getElementById('photo-preuve');
            const dt = new DataTransfer();
            const files = input.files;

            // Itérer dans les fichiers déjà ajoutés et tous les mettre dans "dt" sauf celui qui a été supprimé.
            for (let j = 0; j < files.length; j++)
                if (j !== i)
                    dt.items.add(files[j]);

            // Assigner la nouvelle liste de fichiers au input du DOM
            input.files = dt.files;

            // Faire un "reset" de la liste, donc cacher toutes les images et les réafficher selon la nouvelle liste du DOM.
            hideAddedImages();
            displayAddedImages(document.getElementById('photo-preuve'));
        });
    }

    /************************************************************************************/
    /* Cette fonction ne fait qu'itérer dans toutes les zones pré-codées et s'assure    */
    /* qu'elles seront cachées.                                                         */
    /************************************************************************************/

    function hideAddedImages(){
        for(let i = 0; i < 10; i++)
            document.getElementById("img-" + i).classList.add("hidden");
    }



    /************************************************************************************/
    /*                         GESTION DES PHOTOS D'IDENTITÉ                            */
    /************************************************************************************/

    /************************************************************************************/
    /* Mettre les photos dans la balise "input", sinon afficher un message d'erreur     */
    /************************************************************************************/

    document.getElementById("add-photo-identite").addEventListener('click', function () {
        // Itérer dans les espaces du tableau de fichiers du input
        for (let i = 0; i < 3; i++) {
            // Si un emplacement est vide, on peut procéder à l'ajout des fichiers (plus de gestion d'erreurs est faite dans la fonction addImages())
            if (!document.getElementById('photo-identite').files[i]) {
                addImagesIdentite();
                // Une fois l'ajout fait, on peut quitter.
                return;
            }
        }
        // Si on a pas rencontré la condition "IF", c'est que les 3 emplacements sont occupés et qu'on essaie d'ajouter des images. On doit donc afficher le message d'erreur.
        document.getElementById('i-nb-photo-msg').classList.add("text-red-500", "font-bold");
    });

    /************************************************************************************/
    /* Si on ajoute une image, afficher son nom dans la liste (ces balises sont déjà    */
    /* faites dans le HTML, on fait juste les afficher au besoin)                       */
    /************************************************************************************/

    document.getElementById('photo-identite').addEventListener('change', displayAddedImagesIdentite);

    /************************************************************************************/
    /* Cette fonction fait en sorte que l'utilisateur peut ajouter des images à l'aide  */
    /* d'un input, dans pour autant les remplacer comme l'input ferait normalement.     */
    /************************************************************************************/
    function addImagesIdentite() {
        const input = document.getElementById('photo-identite');
        const dt = new DataTransfer();
        const existingFiles = input.files;

        // Ajouter les fichiers déjà ajoutés dans "input" à la liste du DataTransfer
        for (let i = 0; i < existingFiles.length; i++)
            dt.items.add(existingFiles[i]);

        // Créer un "input" temporaire pour que l'utilisateur puisse ajouter de nouvelles photos
        const newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.multiple = true;
        newInput.accept="image/jpeg, image/jpg, image/png"

        // Ajouter un EventListener une fois que l'utilisateur a mis ses images pour traiter les changements
        newInput.onchange = function(event) {
            const newFiles = event.target.files;

            // Si les nouveaux fichiers et les anciens dépassent 3, afficher le message d'erreur et ignorer les entrées
            if(dt.items.length + newFiles.length > 3)
                document.getElementById('i-nb-photo-msg').classList.add("text-red-500", "font-bold");

            // Si on est en dessous ou égal à 3, procéder à l'ajout des nouvelles images
            else
            {
                // Effacer le message d'erreur
                document.getElementById('i-nb-photo-msg').classList.remove("text-red-500", "font-bold");

                // Ajout des images à l'objet DataTransfer
                for (let i = 0; i < newFiles.length; i++)
                    if(dt.items.length <= 3)
                        dt.items.add(newFiles[i]);
            }

            // Assigner les nouvelles images
            input.files = dt.files;
            displayAddedImagesIdentite(input);
        };

        // Une fois le EventListener ajouté, trigger l'objet pour que l'utilisateur ajoute des images
        newInput.click();
    };

    /************************************************************************************/
    /* Cette fonction fait en sorte que les images ajoutées sont affichées dans une     */
    /* liste afin que l'utilisateur puisse voir quelles images ont été sélectionnées et */
    /* les supprimer au besoin.                                                         */
    /************************************************************************************/

    function displayAddedImagesIdentite(evt){
        // Si appel ient d'un eventListener
        let input = evt.target;

        // Si appel vient de la suppression d'image (plus bas), le input est passé en paramètre mais n'est pas un évènement
        if(!input)
            input = evt;

        // Liste de fichiers
        let files = input.files;

        // Pour 3 fichiers maximum
        for (let i = 0; i < 3; i++)
        {
            // Si le fichier existe, afficher la zone prévue à cet effet et changer le texte interne pour le nom du fichier
            if (files[i]) {
                document.getElementById("i-img-" + i).classList.remove("hidden");
                document.getElementById("i-img-" + i).classList.add("flex");
                document.getElementById("i-img-" + i).firstChild.nextSibling.innerHTML = files[i].name;
            }
        }
    }

    /************************************************************************************/
    /* Gestion de la suppression d'images de la liste (si l'utilisateur clique sur le X)*/
    /************************************************************************************/

    // Pour chacune des 3 images, ajout du EventListener
    for (let i = 0; i < 3; i++)
    {
        // Cette fonction fera en sorte que les images seront décalées d'un emplacement si une image précédente est supprimée du tableau.
        document.getElementById('i-remove-img-' + i).addEventListener('click', function (){

            // Supprimer le message d'erreur s'il était affiché, car l'utilisateur a compris qu'il essaie d'envoyer trop d'images.
            document.getElementById('i-nb-photo-msg').classList.remove("text-red-500", "font-bold");

            const input = document.getElementById('photo-identite');
            const dt = new DataTransfer();
            const files = input.files;

            // Itérer dans les fichiers déjà ajoutés et tous les mettre dans "dt" sauf celui qui a été supprimé.
            for (let j = 0; j < files.length; j++)
                if (j !== i)
                    dt.items.add(files[j]);

            // Assigner la nouvelle liste de fichiers au input du DOM
            input.files = dt.files;

            // Faire un "reset" de la liste, donc cacher toutes les images et les réafficher selon la nouvelle liste du DOM.
            hideAddedImagesIdentite();
            displayAddedImagesIdentite(document.getElementById('photo-identite'));
        });
    }

    /************************************************************************************/
    /* Cette fonction ne fait qu'itérer dans toutes les zones pré-codées et s'assure    */
    /* qu'elles seront cachées.                                                         */
    /************************************************************************************/

    function hideAddedImagesIdentite(){
        for(let i = 0; i < 3; i++)
            document.getElementById("i-img-" + i).classList.add("hidden");
    }
}
