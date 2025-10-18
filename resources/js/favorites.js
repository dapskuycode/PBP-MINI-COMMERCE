// Favorites functionality
window.toggleFavorite = async function(productId, event) {
    try {
        const response = await fetch(`/favorites/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const data = await response.json();

        if (data.success) {
            // Update heart icons based on favorite status (for product pages)
            const outlineIcon = document.getElementById('fav-outline') || document.getElementById(`fav-outline-${productId}`);
            const solidIcon = document.getElementById('fav-solid') || document.getElementById(`fav-solid-${productId}`);

            if (outlineIcon && solidIcon) {
                // This is probably a product page with heart icons
                if (data.is_favorited) {
                    outlineIcon.classList.add('hidden');
                    solidIcon.classList.remove('hidden');
                } else {
                    outlineIcon.classList.remove('hidden');
                    solidIcon.classList.add('hidden');
                }
            } else if (event && event.target && !data.is_favorited) {
                // This might be favorites page - remove the card
                const button = event.target.closest('button');
                const card = button ? button.closest('.relative') : null;
                
                if (card) {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.95)';
                    card.style.transition = 'all 0.3s ease';
                    
                    setTimeout(() => {
                        card.remove();
                    }, 300);
                }
            }

            // Show notification
            showNotification(data.message, data.is_favorited ? 'success' : 'info');
        } else {
            showNotification(data.message, 'error');
        }
    } catch (error) {
        console.error('Error toggling favorite:', error);
        showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
    }
};

// Show notification function
window.showNotification = function(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg text-white z-50 transition-all duration-300 ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        'bg-blue-500'
    }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
};