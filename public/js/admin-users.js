if (document.baseURI.includes('admin/utilisateurs')) {
    let selectType = document.getElementById("type");
    let filterForm = document.getElementById("filterForm");
    let pageLink = document.getElementsByClassName("pageLink");

    selectType.addEventListener("change", function(){filterForm.submit();});

    for(let i = 0; i < pageLink.length; i++)
    {
        pageLink[i].addEventListener("click", function(){
            document.getElementById("pageID").value = parseInt(pageLink[i].innerHTML);
            filterForm.submit();
        });
    }

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

