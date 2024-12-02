document.addEventListener('DOMContentLoaded', function () {
    const notificationItems = document.querySelectorAll('.notification-item');

    notificationItems.forEach((item) => {
        let startX = 0;
        let currentX = 0;
        let isDragging = false;

        // Mouse down to initiate drag
        item.addEventListener('mousedown', (e) => {
            startX = e.clientX;
            isDragging = true;
        });

        // Dragging effect
        item.addEventListener('mousemove', (e) => {
            if (isDragging) {
                currentX = e.clientX;
                const offset = startX - currentX;

                // If dragging left, reveal the trash icon
                if (offset > 0) {
                    item.style.transform = `translateX(-${Math.min(offset, 80)}px)`;
                }
            }
        });

        // Mouse up to end drag
        item.addEventListener('mouseup', () => {
            isDragging = false;
            item.style.transform = 'translateX(0)';
        });

        // To ensure the dropdown stays open on mouse leave
        item.addEventListener('mouseleave', (e) => {
            if (isDragging) {
                isDragging = false;
                item.style.transform = 'translateX(0)';
            }
        });
    });
});

function hideNotification(notificationId, notificationElement) {
    console.log(window.notificationHideRoute);
    fetch(window.notificationHideRoute, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.csrfToken // Use the CSRF token variable
        },
        body: JSON.stringify({ id_notification: notificationId })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Something went wrong');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            // Immediately hide the notification in the UI
            if (notificationElement) {
                notificationElement.style.display = 'none';
                let count = parseInt(document.getElementById('notificationCount').innerHTML.replace(/\s/g, ""));
                if(count > 1)
                    document.getElementById('notificationCount').innerHTML =  count - 1;
                else
                    document.getElementById('notificationCount').style.display = 'none';
            }
        } else {
            console.error('Failed to hide notification');
        }
    })
    .catch(error => console.error('Error:', error));
}

window.hideNotification = hideNotification;
