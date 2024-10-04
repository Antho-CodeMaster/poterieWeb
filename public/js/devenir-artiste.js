if (document.baseURI.includes('devenir-artiste')) {
    // Changer le message affiché si l'utilisateur veut être étudiant VS professionnel
    let select = document.getElementsByTagName("select")[0];

    select.addEventListener('change', switchMessage);

    function switchMessage(evt) {
        if (evt.target.value == "etu") {
            document.getElementById("variable-message-pro").classList.add("hidden");
            document.getElementById("variable-message-etu").classList.remove("hidden");
        }
        else if (evt.target.value == "pro") {
            document.getElementById("variable-message-etu").classList.add("hidden");
            document.getElementById("variable-message-pro").classList.remove("hidden");
        }
    }

    // Mettre les photos dans la balise "input", sinon afficher un message d'erreur
    document.getElementById("add-photo-preuve").addEventListener('click', function () {
        for (let i = 0; i < 5; i++) {
            if (!document.getElementById('photo-preuve').files[i]) {
                addImageEvenThoughSomeMightHaveAlreadyBeenAdded();
                return;
            }
        }
        document.getElementById('nb-photo-msg').classList.add("text-red-500", "font-bold");
    });

    // Si on ajoute une image, afficher son nom dans la liste (ces balises sont déjà faites dans le HTML, on fait juste les afficher au besoin)
    document.getElementById('photo-preuve').addEventListener('change', displayAddedImages);

    function addImageEvenThoughSomeMightHaveAlreadyBeenAdded() {
        const input = document.getElementById('photo-preuve');
        const dt = new DataTransfer(); // Create a new DataTransfer object
        const existingFiles = input.files;

        // Add the existing files to the DataTransfer object
        for (let i = 0; i < existingFiles.length; i++) {
            dt.items.add(existingFiles[i]);
        }

        // Prompt the user to select new files
        const newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.multiple = true;
        newInput.accept="image/jpeg, image/jpg, image/png"
        newInput.onchange = function(event) {
            const newFiles = event.target.files;

            // S'il y a trop de fichiers dans newFiles, afficher le message d'erreur
            if(dt.items.length + newFiles.length > 5)
            {
                document.getElementById('nb-photo-msg').classList.add("text-red-500", "font-bold");
            }
            else
            {
                // Effacer le message d'erreur
                document.getElementById('nb-photo-msg').classList.remove("text-red-500", "font-bold");
                // Add the newly selected files to the DataTransfer object
                for (let i = 0; i < newFiles.length; i++) {
                    if(dt.items.length <= 5)
                        dt.items.add(newFiles[i]);
                }
            }

            // Assign the combined FileList back to the original file input
            input.files = dt.files;
            displayAddedImages(input);
        };

        // Trigger the new file input dialog
        newInput.click();
    };

    function displayAddedImages(evt){
        // Si appel venant d'un eventListener
        let input = evt.target;

        // Si appel venant de la suppression d'image (plus bas)
        if(!input)
            input = evt;

        let files = input.files;

        for(let i = 0; i < 5; i++)
        {
            if (files[i]) {
                document.getElementById("img-" + i).classList.remove("hidden");
                document.getElementById("img-" + i).classList.add("flex");
                document.getElementById("img-" + i).firstChild.nextSibling.innerHTML = files[i].name;
            } else {
                console.log("No file selected for id" + i);
            }
        }
        console.log(document.getElementById('photo-preuve').files);
    }

    // Si on veut supprimer une image, la supprimer du tableau de fichiers et ré-afficher les images ajoutées pour préserver le nouvel ordre

    for(let i = 0; i < 5; i++)
    {
        document.getElementById('remove-img-' + i).addEventListener('click', function (){

            // Supprimer message d'erreur s'il était affiché
            document.getElementById('nb-photo-msg').classList.remove("text-red-500", "font-bold");

            const input = document.getElementById('photo-preuve');
            const dt = new DataTransfer(); // Create a new DataTransfer object
            const files = input.files;

            // Loop through all files and add all except the one we want to remove
            for (let j = 0; j < files.length; j++) {
                if (j !== i) {
                    dt.items.add(files[j]); // Add files back to DataTransfer
                }
            }

            // Assign the updated FileList back to the input
            input.files = dt.files;

            hideAddedImages();
            displayAddedImages(document.getElementById('photo-preuve'));
        });
    }

    function hideAddedImages(){
        for(let i = 0; i < 5; i++)
            document.getElementById("img-" + i).classList.add("hidden");
    }
}
