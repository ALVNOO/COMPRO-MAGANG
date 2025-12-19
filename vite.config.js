import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/public-app.css',
                'resources/js/public-app.js',
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
