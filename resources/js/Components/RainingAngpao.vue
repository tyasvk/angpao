<script setup>
import { onMounted, onUnmounted } from 'vue';
import confetti from 'canvas-confetti';

let intervalId = null;

// Palet warna: Merah Hoki, Merah Gelap, Emas, dan Krem Terang
const colors = ['#e60000', '#990000', '#ffcc00', '#ffe7ba'];

const startRain = () => {
    // Fungsi untuk membuat satu "tetesan" hujan
    const launchConfetti = () => {
        confetti({
            particleCount: 3, // Luncurkan 3 partikel sekaligus
            angle: 90, // Arah lurus ke bawah
            spread: 180, // Menyebar lebar dari atas layar
            // Mulai dari posisi X acak, sedikit di atas layar (y: -0.1)
            origin: { x: Math.random(), y: -0.1 }, 
            colors: colors,
            shapes: ['square'], // Bentuk kotak seperti kertas angpao/konfeti
            gravity: 0.6, // Kecepatan jatuh sedang
            scalar: 1.2, // Ukuran sedikit lebih besar dari default
            drift: (Math.random() - 0.5) * 1, // Efek melayang kiri-kanan acak
            ticks: 500, // Partikel bertahan lama di layar sebelum hilang
            zIndex: -1, // PENTING: Taruh di belakang konten utama
            disableForReducedMotion: true // Menghormati pengaturan user yang sensitif gerakan
        });
    };

    // Jalankan peluncuran setiap 200 milidetik untuk efek hujan terus menerus
    intervalId = setInterval(launchConfetti, 200);
};

onMounted(() => {
    // Mulai hujan saat komponen dimuat
    startRain();
});

onUnmounted(() => {
    // PENTING: Hentikan interval dan bersihkan canvas saat pindah halaman
    // agar tidak memakan memori browser.
    if (intervalId) clearInterval(intervalId);
    confetti.reset();
});
</script>

<template>
    <div class="hidden"></div>
</template>