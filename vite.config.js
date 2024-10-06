import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    /* For docker to work */
    server: {
        host: true,
        hmr: {
            host: "localhost",
        },
    },

    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
});
