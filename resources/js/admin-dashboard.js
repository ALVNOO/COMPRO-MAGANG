// Import Bootstrap Bundle (includes Popper.js)
import 'bootstrap';

// Import jQuery
import $ from 'jquery';
window.$ = window.jQuery = $;

// Import Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Admin dashboard initialization
console.log('Admin dashboard loaded');

// Alert auto hide
$(document).ready(function() {
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);

    // Dropdown (simple Tailwind, manual toggle)
    $('#adminDropdown').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const $menu = $(this).next('.dropdown-menu');
        $menu.toggleClass('hidden');
    });

    // Close dropdown when clicking outside
    $(document).on('click', function(event) {
        const $dropdown = $('.dropdown-menu');
        const $button = $('#adminDropdown');
        const $dropdownContainer = $button.parent();

        // Check if click is outside both button and dropdown
        if (!$dropdownContainer.is(event.target) && !$dropdownContainer.has(event.target).length) {
            $dropdown.addClass('hidden');
        }
    });

    // Prevent dropdown from closing when clicking inside the dropdown menu
    $('.dropdown-menu').on('click', function(e) {
        e.stopPropagation();
    });

    // Ensure logout button is clickable
    $('.dropdown-menu button[type="submit"]').on('click', function(e) {
        // Allow the form to submit normally
        e.stopPropagation();
        // Don't prevent default - let the form submit
    });
});

// Auto-hide notifications after 3 seconds
document.addEventListener('DOMContentLoaded', function() {
    const notifications = document.querySelectorAll('.alert-notification');
    notifications.forEach(function(notification) {
        setTimeout(function() {
            notification.style.transition = 'opacity 0.5s ease-out';
            notification.style.opacity = '0';
            setTimeout(function() {
                notification.remove();
            }, 500);
        }, 3000);
    });
});
