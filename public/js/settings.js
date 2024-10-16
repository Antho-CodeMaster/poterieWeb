//Settings to show the artist's profile picture
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the profile edit page
    if (document.baseURI.includes("profile/personnaliser")) {
        var imageInput = document.getElementById('image-input');
        var imagePreview = document.getElementById('image-preview');

        // If image input and preview elements are found, bind the event
        if (imageInput && imagePreview) {
            imageInput.addEventListener('change', function(event) {
                imagePreview.src = URL.createObjectURL(event.target.files[0]);
                imagePreview.onload = function() {
                    URL.revokeObjectURL(imagePreview.src); // Free up memory
                }
            });
        }
    }

    //Check if the path contains 'profile'
    if (document.baseURI.includes("profile")) {
        document.getElementById('hamburger').addEventListener('click', function() {
            let menu = document.getElementById('menu-gauche');
            menu.classList.toggle('hidden'); // Just toggle visibility
            menu.classList.toggle('top-24');
        });
    }

});

