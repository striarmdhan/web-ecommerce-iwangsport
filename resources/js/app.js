import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

window.Alpine = Alpine;

// Register plugins
Alpine.plugin(collapse);

// Start Alpine.js
Alpine.start();

// Auto-submit filter form when dropdown changes
document.addEventListener('alpine:init', () => {
    // Global event listener for filter changes
    window.addEventListener('filter-changed', (event) => {
        const form = document.getElementById('filterForm');
        if (form) {
            setTimeout(() => form.submit(), 100);
        }
    });
});
