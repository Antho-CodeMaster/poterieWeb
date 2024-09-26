window.onload = () => {
    if (document.baseURI.includes("kiosque")) {

        function animationText(){
            const textElement = document.getElementById('scrollingText');
            const parentElement = textElement.parentElement;

            // Vérifie si la largeur du texte dépasse celle du conteneur
            if (textElement.scrollWidth > parentElement.clientWidth) {
                textElement.classList.add('animate-scrollText');
            } else {
                textElement.classList.remove('animate-scrollText');
            }
        }

        animationText()
    };
}
