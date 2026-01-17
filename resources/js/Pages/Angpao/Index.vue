<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import RainingAngpao from '@/Components/RainingAngpao.vue';

const props = defineProps({
    settings: Object,
    availableRewards: Array,
    myGifts: Array,
});

const form = useForm({
    code: '',
});

const submitClaim = () => {
    form.post(route('angpao.claim'), {
        onSuccess: () => form.reset(),
    });
};

const isPlaying = ref(false);
const audioPlayer = ref(null);

const toggleMusic = () => {
    if (isPlaying.value) audioPlayer.value.pause();
    else audioPlayer.value.play();
    isPlaying.value = !isPlaying.value;
};
</script>

<template>
    <Head :title="(settings?.welcome_title || 'Imperial Fortune') + ' — Claim Access'" />

    <RainingAngpao />

    <div class="min-h-screen lg:h-screen w-full bg-[#4A0000] flex flex-col lg:flex-row relative overflow-hidden font-sans text-[#F9E498]">
        
        <div class="fixed inset-0 opacity-5 pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/chinese-lanterns.png')]"></div>
        
        <div class="fixed top-0 left-0 w-full h-1 bg-gradient-to-r from-[#D4AF37] via-[#F9E498] to-[#AA8A2E] z-50"></div>
        <div class="fixed bottom-0 left-0 w-full h-1 bg-gradient-to-r from-[#AA8A2E] via-[#F9E498] to-[#D4AF37] z-50"></div>

        <section class="w-full lg:w-5/12 p-5 lg:p-8 flex flex-col relative z-10 lg:border-r-2 lg:border-[#D4AF37]/20 bg-[#660000]/10 backdrop-blur-sm">
            <div class="mb-6 text-center flex flex-col items-center">
                <h3 class="text-[8px] font-black uppercase tracking-[0.4em] text-[#D4AF37] mb-1 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] animate-pulse"></span>
                    Manifest Karunia
                    <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] animate-pulse"></span>
                </h3>
                <h2 class="text-xl font-black uppercase tracking-widest leading-none">
                    Karunia <span class="text-white text-lg block mt-1">Tersedia</span>
                </h2>
            </div>

            <div class="flex-1 overflow-y-auto custom-scroll px-2">
                <div class="flex flex-col items-center gap-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-1 gap-3 w-full max-w-[280px]">
                        <div v-for="(reward, index) in availableRewards" :key="index" 
                             class="flex items-center gap-4 bg-[#4A0000]/60 border border-[#D4AF37]/20 p-3 rounded-2xl group hover:border-[#F9E498] transition-all shadow-lg w-full">
                            <div class="w-10 h-10 shrink-0 bg-gradient-to-br from-[#D4AF37] to-[#AA8A2E] rounded-xl flex items-center justify-center text-xl shadow-md group-hover:scale-110 transition-transform">
                                {{ reward.reward_type === 'money' ? '💰' : '🎁' }}
                            </div>
                            <div class="flex flex-col min-w-0 text-left">
                                <span class="text-[10px] font-black uppercase tracking-widest text-[#F9E498] truncate">{{ reward.reward_name }}</span>
                                <span class="text-[7px] font-black uppercase tracking-widest text-[#D4AF37]/40">{{ reward.reward_type }}</span>
                            </div>
                        </div>
                    </div>

                    <div v-if="availableRewards.length === 0" class="py-10 text-center opacity-20 text-[9px] uppercase tracking-widest">
                        Seluruh Karunia Telah Terbagi
                    </div>

                    <div v-if="myGifts?.length > 0" class="mt-6 pt-4 border-t border-[#D4AF37]/10 w-full max-w-[250px] text-center">
                        <p class="text-[8px] font-black uppercase tracking-[0.2em] opacity-30 mb-3 text-center">Riwayat Klaim Anda</p>
                        <div class="flex flex-col items-center gap-1.5">
                            <div v-for="gift in myGifts.slice(0, 2)" :key="gift.id" 
                                 class="text-[8px] font-black uppercase tracking-widest opacity-60 bg-[#4A0000]/40 px-3 py-1 rounded-lg border border-[#D4AF37]/10 w-full">
                                🏮 {{ gift.reward_name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="w-full lg:w-7/12 p-6 flex flex-col items-center justify-center relative z-10 bg-[#4A0000]/30">
            <div class="max-w-xs w-full space-y-6 text-center">
                
                <div class="space-y-4">
                    <div class="relative inline-block">
                        <div class="absolute inset-0 bg-[#D4AF37] blur-[30px] opacity-20 scale-125"></div>
                        <div class="w-20 h-20 bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] rounded-[1.5rem] flex items-center justify-center text-4xl shadow-2xl mx-auto rotate-2 border-2 border-[#D4AF37] relative z-10">
                            🧧
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black tracking-[0.2em] uppercase text-transparent bg-clip-text bg-gradient-to-b from-[#F9E498] via-[#D4AF37] to-[#AA8A2E] leading-none mb-1">
                            {{ settings?.welcome_title || 'Imperial Fortune' }}
                        </h1>
                        <p class="text-[8px] font-black text-[#F9E498] tracking-[0.4em] uppercase opacity-60">
                            {{ settings?.welcome_subtitle || 'Fortune Access • 2026' }}
                        </p>
                    </div>
                </div>

                <div class="bg-gradient-to-b from-[#991B1B] to-[#7F1D1D] p-6 lg:p-8 rounded-[2.5rem] border-2 border-[#D4AF37] shadow-2xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_transparent_0%,_black_150%)] opacity-40"></div>
                    
                    <form @submit.prevent="submitClaim" class="space-y-6 relative z-10">
                        <div class="space-y-2">
                            <label class="text-[8px] font-black text-[#F9E498] uppercase tracking-[0.3em] block opacity-40">
                                Imperial Code Access
                            </label>
                            <input 
                                v-model="form.code" 
                                type="text" 
                                placeholder="INPUT KODE"
                                class="w-full py-4 px-3 bg-[#4A0000]/60 border border-[#D4AF37]/30 rounded-2xl text-center text-xl font-black tracking-[0.2em] text-[#F9E498] uppercase placeholder:text-[#F9E498]/10 focus:border-[#F9E498] transition-all outline-none shadow-inner"
                                required
                            >
                            <p v-if="$page.props.flash.error" class="text-red-400 font-black text-[8px] uppercase tracking-widest py-2">
                                {{ $page.props.flash.error }}
                            </p>
                        </div>

                        <button 
                            :disabled="form.processing"
                            class="w-full py-4 bg-gradient-to-r from-[#D4AF37] via-[#F9E498] to-[#D4AF37] text-[#4A0000] font-black text-[10px] uppercase tracking-[0.4em] rounded-2xl shadow-lg hover:scale-[1.02] active:scale-95 transition-all disabled:opacity-50"
                        >
                            {{ form.processing ? 'Verifying...' : 'Buka Karunia 🧧' }}
                        </button>
                    </form>
                </div>

                <p class="text-[7px] font-black text-[#D4AF37] uppercase tracking-[0.3em] opacity-30">
                    Imperial Palace Guard &bull; Authenticity 2026
                </p>
            </div>
        </section>

        <div class="fixed bottom-4 right-4 z-50 flex flex-col items-center gap-2">
            <button @click="toggleMusic" class="w-10 h-10 bg-gradient-to-tr from-[#D4AF37] to-[#F9E498] rounded-xl shadow-xl flex items-center justify-center text-lg border border-white/20 hover:scale-110 active:scale-90 transition-all">
                {{ isPlaying ? '🎵' : '🔇' }}
            </button>
            <audio ref="audioPlayer" loop src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"></audio>
        </div>

        <div class="fixed bottom-4 left-0 w-full flex justify-around opacity-5 text-4xl pointer-events-none z-0">
            <span>☁️</span><span>☁️</span><span>☁️</span>
        </div>
    </div>
</template>

<style>
body {
    margin: 0;
    padding: 0;
    background-color: #4A0000;
    overflow: hidden;
}

.custom-scroll::-webkit-scrollbar { width: 3px; }
.custom-scroll::-webkit-scrollbar-thumb { background: #D4AF37; border-radius: 10px; }

@keyframes sway {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.animate-sway { animation: sway 3s ease-in-out infinite; }

* { font-style: normal !important; }
</style>