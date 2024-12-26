import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import mkcert from 'vite-plugin-mkcert';

export default defineConfig({
    plugins: [

        laravel({
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
