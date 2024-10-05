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

            if(demandeIndex == demandes.length - 1)
                evt.target.classList.add("invisible");
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

            if(demandeIndex == 0)
                evt.target.classList.add("invisible");
        }
    });
}
