if (document.baseURI.includes("admin/demandes")) {

    let demandes = document.getElementsByClassName("demande");
    let demandeIndex = 0;
    demandes[0].classList.remove("hidden");
    demandes[0].classList.add("flex");

    /* Gestion du caroussel */
    document.getElementById('nextBtn').addEventListener('click', function (evt) {
        if (demandeIndex < demandes.length - 1) {
            document.getElementById('prevBtn').classList.remove("invisible");
            demandes[demandeIndex].classList.add("hidden");
            demandes[demandeIndex].classList.remove("flex");
            demandeIndex++;
            demandes[demandeIndex].classList.remove("hidden");
            demandes[demandeIndex].classList.add("flex");

            if (demandeIndex == demandes.length - 1)
                evt.target.classList.add("invisible");

            console.log(demandeIndex);
        }
    });

    document.getElementById('prevBtn').addEventListener('click', function (evt) {
        if (demandeIndex > 0) {
            document.getElementById('nextBtn').classList.remove("invisible");

            demandes[demandeIndex].classList.add("hidden");
            demandes[demandeIndex].classList.remove("flex");
            demandeIndex--;
            demandes[demandeIndex].classList.remove("hidden");
            demandes[demandeIndex].classList.add("flex");

            if (demandeIndex == 0)
                evt.target.classList.add("invisible");

            console.log(demandeIndex);
        }
    });

    /* Gestion du modal */

    // Get the modal
    var modal = document.getElementById('imgModal');

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementsByClassName('img');
    var modalImg = document.getElementById("imgFull");

    for(let i = 0; i < img.length; i++)
        img[i].onclick = function () {
            modal.style.display = "flex";
            modalImg.src = this.src;
        }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }
}
