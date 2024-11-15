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

window.toggleLike = function(articleId) {
    const url = window.likeToggleUrl.replace(':idArticle', articleId);

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.csrfToken
        },
        body: JSON.stringify({ article_id: articleId })
    })
    .then(response => {
        if (response.ok) {
            return response.json();  // Return the parsed JSON if response is okay
        } else {
            console.error('Error liking the article');
        }
    })
    .then(result => {
        if (result) {
            return result.liked;  // Return the new liked status
        }
    })
    .catch(error => {
        console.error('Error:', error);  // Handle any errors during the fetch
    });
};
