if (document.baseURI.includes("decouverte") || window.location.pathname === '/') {
    let closeThanks = document.getElementById("closeThanksModal");

    if (closeThanks != null) {
        closeThanks.addEventListener("click", function () {
            document.getElementById("thanksModal").classList.add("hidden");
        })
    }

    document.addEventListener('DOMContentLoaded', function () {
        const collections = document.querySelectorAll('[data-collection-id]');

        collections.forEach(collection => {
            const collectionId = collection.getAttribute('data-collection-id');
            const carousel = document.getElementById('carousel-' + collectionId);
            const nextBtn = document.getElementById('nextBtn-' + collectionId);
            const prevBtn = document.getElementById('prevBtn-' + collectionId);

            // Add event listeners for the next and previous buttons
            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    carousel.scrollBy({ left: 300, behavior: 'smooth' });
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    carousel.scrollBy({ left: -300, behavior: 'smooth' });
                });
            }
        });
    });
}
