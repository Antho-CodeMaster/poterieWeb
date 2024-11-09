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

window.colorPicker = function() {
    return {
        colors: ['slate', 'gray', 'zinc', 'neutral', 'stone', 'red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose'],
        variants: [100, 200, 300, 400, 500, 600, 700, 800, 900],
        currentColor: '',
        iconColor: '',
        isColorPickerOpen: false,

        initColor(defaultColor) {
            this.currentColor = defaultColor;
            const variant = this.extractVariant(defaultColor);

            if (variant < 500) {
                this.setIconBlack();
            } else {
                this.setIconWhite();
            }
            console.log(`Default color: ${defaultColor}, Variant: ${variant}`);
        },

        extractVariant(colorString) {
            const match = colorString.match(/\d+$/);
            return match ? parseInt(match[0], 10) : 500;
        },

        setIconWhite() {
            this.iconColor = 'text-beige';
        },

        setIconBlack() {
            this.iconColor = 'text-darkGrey';
        },

        selectColor(color, variant) {
            this.currentColor = `bg-${color}-${variant}`;

            if (variant < 500) this.setIconBlack();
            else this.setIconWhite();
        },

        handleCloseDropdown() {
            setTimeout(() => {
                this.isColorPickerOpen = false;
            }, 200);
        }
    };
};
