//Settings to show the artist's profil picture
document.addEventListener('DOMContentLoaded', function() {
    //Check if the path contains 'profil'
    if (document.baseURI.includes("profil")) {
        document.getElementById('hamburger').addEventListener('click', function() {
            let menu = document.getElementById('menu-gauche');

            menu.classList.toggle('hidden');
            menu.classList.toggle('top-24');
        });
    }

    // Check if we're on the profil edit page
    if (document.baseURI.includes("profil/personnaliser")) {
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


window.socialMediaHandler = function() {
    return {
        // Array to Track All Input Fields
        fields: [],

        // Array to Track Removed Fields (Ids and Names)
        removedFields: [],

        // Add a New Field
        addField() {
            this.fields.push({ username: '', reseau_id: '' }); // Add new object with empty fields
        },

        // Remove a Field by Index (Visually Hide It)
        removeField(index) {
            this.fields.splice(index, 1); // Remove field at the specified index
        },

        // Remove Existing Field and Track It for Removal
        removeExistingField(reseauId, userName) {
            const removed = { id_reseau: reseauId, username: userName };
            console.log(removed);
            if (!this.removedFields.some(field => field.id_reseau === reseauId && field.username === userName)) {
                this.removedFields.push(removed); // Add to removedFields array if not already present
            }
        }
    };
}
