if (document.baseURI.includes('/panier')) {
    document.addEventListener('DOMContentLoaded', function () {
        console.log("works ig");
        // Function to update the panier summary
        async function updatePanierSummary() {
            let subtotal = 0;
            let totalItems = 0;
            let cartData = [];

            // Get all cart items
            let cartItems = document.querySelectorAll('.itemPanier');

            cartItems.forEach(function (item) {
                let price = parseFloat(item.getAttribute('data-prix'));
                let quantitySelect = item.querySelector('.quantite');
                let quantity = parseInt(quantitySelect.value);
                let article = item.getAttribute('data-ida');
                let transaction = item.getAttribute('data-idt');

                subtotal += price * quantity;
                totalItems += quantity;

                cartData.push({
                    idTransaction: transaction,
                    idArticle: article,
                    quantity: quantity
                });
            });


            // Update subtotal
            document.getElementById('nb').textContent = 'Sous-total (' + totalItems + ' article' + (totalItems !== 1 ? 's' : '') + ')';
            document.getElementById('brut').textContent = subtotal.toFixed(2) + ' $';

            // Calculate delivery fees
            let deliveryFees = calculateDeliveryFees(subtotal);
            document.getElementById('frais').textContent = deliveryFees.toFixed(2) + ' $';

            // Calculate taxes (TPS 5% + TVQ 9.975%)
            let taxes = subtotal * 0.14975;
            document.getElementById('taxes').textContent = taxes.toFixed(2) + ' $';

            // Calculate total
            let total = subtotal + deliveryFees + taxes;
            document.getElementById('total').textContent = total.toFixed(2) + ' $';

            /*fetch('/updateQuantite', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ cart: cartData })
            })
            .then(response => response.json());*/
        }

        // Function to calculate delivery fees
        function calculateDeliveryFees(subtotal) {
            // Si le total est de 0
            if (subtotal == 0) {
                return 0;
            } else {
                return 10; // Frais fixe
            }
        }

        function updateQuantity(){

        }

        // Add event listeners to quantity selects
        let quantitySelects = document.querySelectorAll('.quantite-select');
        quantitySelects.forEach(function (select) {
            select.addEventListener('change', updatePanierSummary);
        });

        // Initial update
        updatePanierSummary();
    });

}
