<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    availableRewards: Array, // Daftar hadiah yang bisa didapatkan
    myGifts: Array           // Daftar hadiah yang sudah diklaim user
});

const form = useForm({
    code: '',
});

const submitClaim = () => {
    form.post(route('angpao.process'), { // Sesuaikan nama rute jika perlu
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Imperial Fortune — Claim Access" />
    
    <div class="min-h-screen w-full bg-[#4A0000] flex flex-col items-center p-6 relative overflow-x-hidden">
        
        <div class="fixed inset-0 opacity-10 pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/chinese-lanterns.png')]"></div>
        
        <div class="fixed top-0 left-12 animate-sway duration-[3000ms] text-6xl drop-shadow-2xl z-20">🏮</div>
        <div class="fixed top-0 right-12 animate-sway duration-[4000ms] text-6xl drop-shadow-2xl z-20">🏮</div>

        <div class="fixed top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#D4AF37] via-[#F9E498] to-[#AA8A2E] z-50"></div>
        <div class="fixed bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#AA8A2E] via-[#F9E498] to-[#D4AF37] z-50"></div>

        <div class="max-w-2xl w-full relative z-10 space-y-12 py-10">
            
            <div class="space-y-10">
                <div class="text-center space-y-4">
                    <div class="relative inline-block group">
                        <div class="absolute inset-0 bg-[#D4AF37] blur-[40px] opacity-30 scale-150 transition-opacity"></div>
                        <div class="w-24 h-24 bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] rounded-[2rem] flex items-center justify-center text-5xl shadow-2xl mx-auto rotate-3 border-4 border-[#D4AF37] relative z-10 transition-transform hover:rotate-0 duration-700">
                            🧧
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black tracking-[0.2em] uppercase text-transparent bg-clip-text bg-gradient-to-b from-[#F9E498] via-[#D4AF37] to-[#AA8A2E] drop-shadow-lg">
                            Imperial Fortune
                        </h1>
                        <p class="text-[10px] font-black text-[#F9E498] tracking-[0.5em] uppercase opacity-80">Fortune Access • Imlek 2026</p>
                    </div>
                </div>

                <div class="bg-gradient-to-b from-[#991B1B] to-[#7F1D1D] p-10 rounded-[3.5rem] border-4 border-[#D4AF37] shadow-[0_30px_70px_-15px_rgba(0,0,0,0.5)] relative overflow-hidden group">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_transparent_0%,_black_150%)] opacity-40"></div>
                    
                    <form @submit.prevent="submitClaim" class="space-y-8 relative z-10">
                        <div class="space-y-3">
                            <label class="text-[9px] font-black text-[#F9E498] uppercase tracking-[0.3em] block text-center">
                                Verify Security Code
                            </label>
                            <input 
                                v-model="form.code" 
                                type="text" 
                                placeholder="MASUKKAN KODE"
                                class="w-full py-6 px-4 bg-[#4A0000]/60 border-2 border-[#D4AF37]/50 rounded-2xl text-center text-2xl font-black tracking-[0.3em] text-[#F9E498] uppercase placeholder:text-[#F9E498]/20 focus:bg-[#4A0000] focus:border-[#F9E498] transition-all outline-none"
                                maxlength="15"
                                required
                            >
                        </div>

                        <button 
                            :disabled="form.processing"
                            class="w-full py-5 bg-gradient-to-r from-[#D4AF37] via-[#F9E498] to-[#D4AF37] text-[#4A0000] font-black text-[11px] uppercase tracking-[0.4em] rounded-2xl shadow-xl hover:scale-[1.03] active:scale-95 transition-all duration-300 disabled:opacity-50"
                        >
                            {{ form.processing ? 'Verifying...' : 'Claim Fortune 🧧' }}
                        </button>
                    </form>
                    <div class="absolute -right-8 -bottom-8 text-[10rem] opacity-[0.05] rotate-12 pointer-events-none">🧧</div>
                </div>
            </div>

            <div class="bg-[#660000]/40 border-4 border-[#D4AF37] rounded-[3rem] p-8 shadow-2xl relative overflow-hidden backdrop-blur-sm">
                <div class="absolute inset-0 opacity-[0.03] pointer-events-none flex items-center justify-center text-[10rem]">💮</div>
                
                <h3 class="text-[10px] font-black uppercase tracking-[0.5em] text-[#D4AF37] mb-8 text-center flex items-center justify-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] animate-pulse"></span>
                    Manifest Karunia Tersedia
                    <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] animate-pulse"></span>
                </h3>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 relative z-10">
                    <div v-for="(reward, index) in availableRewards" :key="index" 
                         class="flex flex-col items-center text-center p-4 bg-[#4A0000]/60 border border-[#D4AF37]/30 rounded-2xl group hover:border-[#F9E498] transition-all">
                        <div class="text-2xl mb-2 group-hover:scale-125 transition-transform duration-500">
                            {{ reward.reward_type === 'money' ? '💰' : '🎁' }}
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest leading-tight">{{ reward.reward_name }}</span>
                    </div>
                    <div v-if="!availableRewards?.length" class="col-span-full py-6 text-center opacity-30 text-[9px] uppercase tracking-widest">
                        Seluruh Karunia Telah Terbagi
                    </div>
                </div>
            </div>

            <div v-if="myGifts?.length > 0" class="bg-[#660000]/40 border-4 border-[#D4AF37] rounded-[3rem] p-8 shadow-2xl relative overflow-hidden">
                <h3 class="text-[10px] font-black uppercase tracking-[0.5em] text-[#D4AF37] mb-6 text-center">
                    Manifest Keberuntungan Anda
                </h3>
                <div class="space-y-3 relative z-10">
                    <div v-for="gift in myGifts" :key="gift.id" class="flex items-center justify-between p-4 bg-[#4A0000]/80 border border-[#D4AF37]/20 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">🧧</span>
                            <span class="text-[10px] font-black uppercase tracking-widest">{{ gift.reward_name }}</span>
                        </div>
                        <span class="text-[8px] opacity-40 uppercase font-black">{{ gift.claimed_at }}</span>
                    </div>
                </div>
            </div>

            <div class="text-center pt-4">
                <p class="text-[8px] font-black text-[#D4AF37] uppercase tracking-[0.4em] opacity-60">
                    Secured by Imperial Palace Guard <br>
                    Authenticity Guaranteed &bull; Imlek 2026
                </p>
            </div>
        </div>

        <div class="fixed bottom-10 left-0 w-full flex justify-around opacity-10 text-7xl pointer-events-none select-none z-0">
            <span>☁️</span><span>☁️</span><span>☁️</span><span>☁️</span><span>☁️</span>
        </div>

        <div class="fixed top-1/4 -left-20 w-80 h-80 bg-red-600 rounded-full blur-[120px] opacity-20 z-0"></div>
        <div class="fixed bottom-1/4 -right-20 w-80 h-80 bg-[#D4AF37] rounded-full blur-[120px] opacity-10 z-0"></div>
    </div>
</template>

<style>
/* Perbaikan Scroll Global */
body {
    margin: 0;
    padding: 0;
    background-color: #4A0000;
    overflow-y: auto !important; /* Izinkan scroll */
    overflow-x: hidden;
}

@keyframes sway {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(2deg); }
}

.animate-sway {
    animation: sway linear infinite;
}

/* Custom Scrollbar */
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-thumb { background: #D4AF37; border-radius: 10px; }
::-webkit-scrollbar-track { background: #4A0000; }

* { font-style: normal !important; }
</style>