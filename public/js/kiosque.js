document.addEventListener('DOMContentLoaded', function () {
    if (document.baseURI.includes("kiosque")) {

        let closeWelcome = document.getElementById("closeWelcomeModal");

        if (closeWelcome != null) {
            closeWelcome.addEventListener("click", function () {
                document.getElementById("welcomeModal").classList.add("hidden");
            })
        }

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
});

