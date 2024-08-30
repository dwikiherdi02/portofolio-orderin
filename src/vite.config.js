import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        https: false,
        host: true,
        strictPort: true,
        port: 8813,
        hmr: {host: 'localhost', protocol: 'ws'},
        watch: {
        usePolling:true,
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
