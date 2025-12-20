// Import Bootstrap Bundle (includes Popper.js)
import * as bootstrap from 'bootstrap';

// Make Bootstrap available globally for inline scripts
window.bootstrap = bootstrap;

// Import Chart.js
import Chart from 'chart.js/auto';

// Make Chart available globally for inline scripts
window.Chart = Chart;

// Sidebar Toggle
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    if (sidebarToggle && sidebar && mainContent) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    }

    // Mobile Sidebar Toggle
    window.toggleMobileSidebar = function() {
        if (sidebar) {
            sidebar.classList.toggle('show');
        }
    };

    // Auto-hide alerts
    setTimeout(function() {
        document.querySelectorAll('.alert-dismissible').forEach(function(alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(function() {
                alert.remove();
            }, 500);
        });
    }, 5000);

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Ensure logout buttons work properly
    document.querySelectorAll('form[action*="logout"] button[type="submit"]').forEach(button => {
        button.addEventListener('click', function(e) {
            // Don't prevent default - let form submit
            e.stopPropagation();
        });
    });

    // Add loading animation to buttons (skip buttons with custom loading handlers)
    document.querySelectorAll('button[type="submit"]').forEach(button => {
        button.addEventListener('click', function(e) {
            // Don't show loading for logout buttons
            if (this.form && this.form.action && this.form.action.includes('logout')) {
                return;
            }

            // Skip buttons that have custom loading structure (.btn-text + .btn-loading)
            if (this.querySelector('.btn-text') && this.querySelector('.btn-loading')) {
                return;
            }

            // Skip loading animation for GET forms (like filter forms)
            if (this.form && this.form.method && this.form.method.toLowerCase() === 'get') {
                return; // Allow GET forms to submit immediately without loading animation
            }

            if (this.form && this.form.checkValidity()) {
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                this.disabled = true;
            }
        });
    });

    // User dropdown toggle
    const userMenuTrigger = document.querySelector('.user-menu-trigger');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    if (userMenuTrigger && dropdownMenu) {
        userMenuTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            // Don't close if clicking on a form button or form element
            if ((event.target.tagName === 'BUTTON' && event.target.type === 'submit') ||
                event.target.closest('form')) {
                return;
            }

            if (!userMenuTrigger.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    }

    // Close dropdown when clicking on menu items (but not form buttons)
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
            // Don't close if it's a form button
            if (e.target.tagName === 'BUTTON' && e.target.type === 'submit') {
                return;
            }
            if (dropdownMenu) {
                dropdownMenu.classList.remove('show');
            }
        });
    });

    // Auto-hide notifications after 3 seconds
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
