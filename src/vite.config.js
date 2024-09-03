import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import obfuscator from 'rollup-plugin-obfuscator';

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
    optimizeDeps: {
        exclude: ['datatables.net-bs5']
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
    build: {
        rollupOptions: {
            plugins: [
                obfuscator({
                    options: {
                        // Your javascript-obfuscator options here
                        // See what's allowed: https://github.com/javascript-obfuscator/javascript-obfuscator
                        compact: true,
                        controlFlowFlattening: true,
                        controlFlowFlatteningThreshold: 1,
                        numbersToExpressions: true,
                        simplify: true,
                        stringArrayShuffle: true,
                        splitStrings: true,
                        stringArrayThreshold: 1,

                        transformObjectKeys: true,
                        identifierNamesGenerator: 'mangled-shuffled'
                        // identifierNamesGenerator: 'hexadecimal'
                        // unicodeEscapeSequence: true,
                    },
                }),
            ],
        },
    },
});
