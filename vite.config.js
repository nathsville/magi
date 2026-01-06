import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    server: {
        host: "0.0.0.0", // Membuka server ke jaringan lokal
        port: 5173, // (Opsional) Memastikan port tetap 5173
        cors: true, // <--- TAMBAHKAN INI (Penting untuk mengatasi blokir CORS)
        hmr: {
            host: "192.168.110.248", // IP Laptop/PC Anda
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
});
