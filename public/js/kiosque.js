window.onload = () => {
    if (document.baseURI.includes("kiosque")) {

        /* Gestion du carrouselle */
        document.getElementById('nextBtn').addEventListener('click', function () {
            let carousel = document.getElementById('carousel');
            carousel.scrollBy({ left: 300, behavior: 'smooth' });
        });

        document.getElementById('prevBtn').addEventListener('click', function () {
            let carousel = document.getElementById('carousel');
            carousel.scrollBy({ left: -300, behavior: 'smooth' });
        });

    }
};
