<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import html2canvas from 'html2canvas';

const props = defineProps({
    reward: Object
});

const currentLang = ref('id');
const cardRef = ref(null); // Referensi untuk elemen yang akan difoto

const translations = {
    id: {
        congrats: 'SELAMAT!',
        subtitle: 'KEBERUNTUNGAN KERAJAAN MILIK ANDA',
        you_got: 'ANDA MENDAPATKAN',
        btn_download: 'SIMPAN BUKTI HADIAH 📸',
        btn_back: 'KEMBALI KE ISTANA',
        footer: 'TUNJUKKAN GAMBAR INI KEPADA PETUGAS KAMI'
    },
    en: {
        congrats: 'CONGRATULATIONS!',
        subtitle: 'THE IMPERIAL LUCK IS YOURS',
        you_got: 'YOU HAVE RECEIVED',
        btn_download: 'SAVE PROOF TO GALLERY 📸',
        btn_back: 'RETURN TO PALACE',
        footer: 'SHOW THIS IMAGE TO OUR OFFICIALS'
    }
};

const toggleLang = () => {
    currentLang.value = currentLang.value === 'id' ? 'en' : 'id';
};

// FUNGSI DOWNLOAD SCREENSHOT
const downloadScreenshot = async () => {
    if (!cardRef.value) return;
    
    const canvas = await html2canvas(cardRef.value, {
        backgroundColor: '#4A0000',
        scale: 2, // Kualitas gambar tinggi
        logging: false,
        useCORS: true // Untuk mendukung gambar dari domain lain (storage)
    });
    
    const link = document.createElement('a');
    link.download = `Imperial-Fortune-${props.reward.code}.png`;
    link.href = canvas.toDataURL('image/png');
    link.click();
};
</script>

<template>
    <Head title="Success — Imperial Fortune" />
    
    <div class="h-screen w-full bg-[#4A0000] flex flex-col items-center justify-center p-6 overflow-hidden relative font-sans text-[#F9E498]">
        
        <div class="absolute inset-0 opacity-10 pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/chinese-lanterns.png')]"></div>
        <div class="fixed top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#D4AF37] via-[#F9E498] to-[#AA8A2E] z-50"></div>
        
        <div class="absolute top-4 left-10 animate-bounce duration-[3000ms] text-6xl">🏮</div>
        <div class="absolute top-4 right-10 animate-bounce duration-[4000ms] text-6xl">🏮</div>

        <div class="max-w-lg w-full text-center space-y-8 relative z-10">
            
            <button @click="toggleLang" class="absolute -top-12 right-0 px-4 py-2 border-2 border-[#D4AF37] rounded-xl text-[9px] font-black uppercase tracking-widest bg-[#4A0000] hover:bg-[#D4AF37] hover:text-[#4A0000] transition-all">
                {{ currentLang === 'id' ? 'ID 🇮🇩' : 'EN 🇺🇸' }}
            </button>

            <div class="space-y-2">
                <h1 class="text-5xl font-black tracking-[0.2em] gold-gradient-text drop-shadow-2xl">
                    {{ translations[currentLang].congrats }}
                </h1>
                <p class="text-[10px] font-black tracking-[0.4em] uppercase opacity-70">
                    {{ translations[currentLang].subtitle }}
                </p>
            </div>

            <div ref="cardRef" class="bg-gradient-to-b from-[#B91C1C] to-[#7F1D1D] p-10 rounded-[4rem] border-4 border-[#D4AF37] shadow-[0_0_80px_rgba(212,175,55,0.2)] relative overflow-hidden group">
                <div class="space-y-6 relative z-10">
                    <p class="text-[11px] font-black uppercase tracking-[0.5em] opacity-60">
                        {{ translations[currentLang].you_got }}
                    </p>

                    <div class="space-y-6">
                        <div v-if="reward.image_path" class="w-44 h-44 mx-auto rounded-3xl border-4 border-[#D4AF37] shadow-2xl overflow-hidden bg-[#4A0000] flex items-center justify-center p-2">
                            <img :src="'/storage/' + reward.image_path" class="w-full h-full object-cover rounded-2xl">
                        </div>
                        <div v-else class="text-7xl mb-4">🧧</div>

                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase drop-shadow-lg">
                            {{ reward.reward_name }}
                        </h2>
                    </div>

                    <div class="pt-6 border-t border-[#D4AF37]/30">
                        <p class="text-[9px] font-black opacity-40 uppercase tracking-widest mb-2">OFFICIAL VOUCHER CODE</p>
                        <span class="font-mono text-xl tracking-[0.3em] font-black bg-[#4A0000]/50 px-6 py-2 rounded-xl border border-[#D4AF37]/40 block w-fit mx-auto">
                            {{ reward.code }}
                        </span>
                    </div>
                </div>
                <div class="absolute -right-10 -bottom-10 text-[12rem] opacity-[0.05] rotate-12 pointer-events-none">🧧</div>
            </div>

            <div class="space-y-4">
                <button @click="downloadScreenshot" class="w-full py-5 bg-[#4A0000] border-2 border-[#D4AF37] text-[#D4AF37] font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-xl hover:bg-[#D4AF37] hover:text-[#4A0000] transition-all">
                    {{ translations[currentLang].btn_download }}
                </button>
                
                <Link href="/" class="inline-block w-full py-5 bg-gradient-to-r from-[#D4AF37] via-[#F9E498] to-[#D4AF37] text-[#4A0000] font-black text-xs uppercase tracking-[0.4em] rounded-2xl shadow-2xl hover:scale-[1.03] transition-all">
                    {{ translations[currentLang].btn_back }}
                </Link>

                <p class="text-[9px] font-black opacity-50 uppercase tracking-[0.3em]">
                    {{ translations[currentLang].footer }}
                </p>
            </div>
        </div>

        <div class="absolute bottom-10 left-10 text-9xl opacity-10 pointer-events-none">☁️</div>
    </div>
</template>

<style scoped>
.gold-gradient-text {
    @apply text-transparent bg-clip-text bg-gradient-to-b from-[#FFF3B0] via-[#D4AF37] to-[#8A6E2F];
}

/* Memastikan font tetap hitam/tebal saat di screenshot */
* { font-style: normal !important; }

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}
.animate-bounce { animation: bounce linear infinite; }
</style>