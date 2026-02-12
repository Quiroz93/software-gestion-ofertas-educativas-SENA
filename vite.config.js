import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                /* Design System Base - DEBE SER PRIMERO */
                'resources/css/design-system.css',
                'resources/css/sena-utilities.css',

                /* Component Styles */
                'resources/css/components/navigation-sena.css',
                'resources/css/components/hero-sena.css',
                'resources/css/components/forms-sena.css',
                'resources/css/components/cards-sena.css',
                'resources/css/components/buttons-sena.css',
                'resources/css/components/badges-sena.css',
                'resources/css/components/alerts-sena.css',
                'resources/css/components/pagination-sena.css',

                /* Area Specific Styles */
                'resources/css/common/app.css',
                'resources/css/public/components.css',
                'resources/css/public/home.css',
                'resources/css/public/programas.css',
                'resources/css/public/ofertas.css',
                'resources/css/public/noticias.css',
                'resources/css/public/inscribirse.css',
                'resources/css/public/centros.css',
                'resources/css/public/instructores.css',
                'resources/css/public/historias-exito.css',
                'resources/css/public/nivel-formaciones.css',
                'resources/css/public/redes.css',
                'resources/css/public/competencias.css',
                'resources/css/welcome.css',
                'resources/css/admin/admin.css',
                'resources/css/admin/admin-layout.css',

                /* JavaScript */
                'resources/js/common/app.js',
                'resources/js/admin/admin.js',
                'resources/js/admin/estadisticas.js',
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
