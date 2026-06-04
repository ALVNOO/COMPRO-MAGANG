import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    // Set ASSET_URL in production to serve compiled assets from a CDN.
    // e.g. ASSET_URL=https://cdn.example.com — Laravel's asset() helper picks this up too.
    base: process.env.ASSET_URL ? process.env.ASSET_URL + '/' : '/',
    plugins: [
        laravel({
            input: [
                // Design System (Single Source of Truth)
                'resources/css/design-system.css',
                // UX Utilities & Animations
                'resources/css/ux-utilities.css',
                // Main App
                'resources/css/app.css',
                'resources/js/app.js',
                // Public Pages
                'resources/css/public-app.css',
                'resources/js/public-app.js',
                // Dashboard CSS
                'resources/css/mentor-dashboard.css',
                'resources/js/mentor-dashboard.js',
                'resources/css/admin-dashboard.css',
                'resources/js/admin-dashboard.js',
                'resources/css/peserta-dashboard.css',
                'resources/js/peserta-dashboard.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
