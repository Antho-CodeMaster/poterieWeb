window.onload = () => {
    if (document.baseURI.includes("kiosque")) {
        function tronquerNoms() {
            const nomArticles = document.querySelectorAll(".article_nom");

            nomArticles.forEach(nomArticle => {
                const divArticle = nomArticle.parentElement.offsetWidth;
                const longueurNomArticle = nomArticle.scrollWidth;

                // Si la largeur du texte dépasse celle du parent
                if (longueurNomArticle > divArticle) {
                    const charCount = Math.floor((divArticle / longueurNomArticle) * nomArticle.textContent.length);
                    nomArticle.textContent = nomArticle.textContent.substring(0, charCount - 1) + '...';
                }
            });
        }

        // Appeler la fonction tronquerNoms
        tronquerNoms();
    }
};
