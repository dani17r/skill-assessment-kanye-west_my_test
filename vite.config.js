import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel(["resources/css/app.css", "resources/app/app.ts"]),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            "@": "/resources/app",
            "@composables": "/resources/app/composables",
            "@components": "/resources/app/components",
            "@modules": "/resources/app/modules",
            "@layouts": "/resources/app/layouts",
            "@pages": "/resources/app/pages",
            "@store": "/resources/app/store",
            "@utils": "/resources/app/utils",
        },
    },
});
