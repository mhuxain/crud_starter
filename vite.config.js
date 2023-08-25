import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'
import { quasar, transformAssetUrls } from '@quasar/vite-plugin'
import { splitVendorChunkPlugin } from 'vite'
import { visualizer } from "rollup-plugin-visualizer";

export default defineConfig({
    plugins: [
        vue({
            template: { transformAssetUrls }
          }),
        splitVendorChunkPlugin(),
        quasar({
            sassVariables: 'resources/js/quasar-variables.sass',
        }),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        visualizer(),
    ],
    server: {
        hmr: {
            host: 'localhost',
        },
    }
});