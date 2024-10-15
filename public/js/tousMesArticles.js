document.addEventListener('DOMContentLoaded', function () {

    // Vérifie si on est sur la bonne page
    if (document.baseURI.includes("tousMesArticles")) {

        /* Récupère les Élements sur la page */
        let minValue = document.getElementById("min-Value");
        let maxValue = document.getElementById("max-Value");

        const rangeFill = document.querySelector(".rangeFill")
        const inputElements = document.querySelectorAll(".slider");

        /* Ajout des événements sur les inputs */
        inputElements.forEach((element) => {
            element.addEventListener("input", validateRange)
        })

        /* Fonction pour valider le range */
        function validateRange() {
            let minPrice = parseInt(inputElements[0].value);
            let maxPrice = parseInt(inputElements[1].value);

            console.log("Valeur min slider:", minPrice);
            console.log("Valeur max slider:", maxPrice);

            /* Échange les valeur si le prix minimum est plus grand que le prix maximum */
            if (minPrice > maxPrice) {
                let tempValue = maxPrice;
                maxPrice = minPrice;
                minPrice = tempValue;
            }

            /* Update le montant minimum et maximum */
            minValue.innerHTML = "$ " + minPrice;
            maxValue.innerHTML = "$ " + maxPrice;

            const minPourcentage = ((minPrice - 10) / 999) * 100;
            const maxPourcentage = ((maxPrice - 10) / 999) * 100;

            /* Remplir la barre du filtre */
            rangeFill.style.left = minPourcentage + "%";
            rangeFill.style.width = maxPourcentage - minPourcentage + "%";
        }

        validateRange()

    };

});
