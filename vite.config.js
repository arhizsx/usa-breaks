import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import mkcert from 'vite-plugin-mkcert';

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
        mkcert()
    ],
});
