document.addEventListener('DOMContentLoaded', () => {
    const modal = document.querySelector('[x-data]');
    const modalTitle = modal.querySelector('[x-text="title"]');
    const modalContent = modal.querySelector('[x-html="content"]');
    const commandeItems = document.querySelectorAll('.commande-item');

    commandeItems.forEach(item => {
        item.addEventListener('click', () => {
            const id = item.getAttribute('data-id');

            // Fetch commande details via AJAX
            fetch(`/commande/details/${id}`)
                .then(response => response.json())
                .then(data => {
                    modal.__x.$data.open = true;
                    modalTitle.textContent = data.title;
                    modalContent.innerHTML = data.content;
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    });
});
