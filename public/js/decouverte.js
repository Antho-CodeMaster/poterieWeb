if (document.baseURI.includes("decouverte") || window.location.pathname === '/') {
    let closeThanks = document.getElementById("closeThanksModal");

    if (closeThanks != null) {
        closeThanks.addEventListener("click", function () {
            document.getElementById("thanksModal").classList.add("hidden");
        })
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Select all collections
        const collections = document.querySelectorAll('.collection');

        collections.forEach(collection => {
            // Get collection ID from the `data-collection-id` attribute
            const collectionId = collection.getAttribute('data-collection-id');

            // Select the carousel, next button, and prev button based on the collection ID
            const carousel = document.getElementById('carousel-' + collectionId);
            const nextBtn = document.getElementById('nextBtn-' + collectionId);
            const prevBtn = document.getElementById('prevBtn-' + collectionId);

            // Check if the buttons and carousel exist
            if (carousel && nextBtn && prevBtn) {
                // Scroll to the next item on next button click
                nextBtn.addEventListener('click', () => {
                    carousel.scrollBy({ left: 300, behavior: 'smooth' });
                });

                // Scroll to the previous item on prev button click
                prevBtn.addEventListener('click', () => {
                    carousel.scrollBy({ left: -300, behavior: 'smooth' });
                });
            }
        });
    });
}
