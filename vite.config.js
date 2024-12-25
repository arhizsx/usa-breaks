import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [

        laravel({
            server: {
                https: true,
                hmr: {
                    protocol: 'wss', // Use WebSocket Secure
                },
            },
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/datagrid.js',
            ],
            refresh: true,
        }),
    ],
});
