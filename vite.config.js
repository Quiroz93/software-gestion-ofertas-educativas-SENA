import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/common/app.css',
                'resources/css/admin/admin.css',
                'resources/css/admin/inline.css',
                'resources/css/public/public.css',
                'resources/js/common/app.js',
                'resources/js/admin/admin.js',
                'resources/js/public/public.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'vendor': ['bootstrap'],
                }
            }
        },
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
            }
        }
    }
});
