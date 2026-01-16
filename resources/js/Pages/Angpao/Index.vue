<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import RainingAngpao from '@/Components/RainingAngpao.vue';

const props = defineProps({
    status: String,
    error: String,
});

// Logic Form Klaim
const form = useForm({
    code: '',
});

const submit = () => {
    form.post(route('angpao.claim'), {
        onSuccess: () => form.reset(),
    });
};

// Logic Musik Latar
const isPlaying = ref(false);
const audioPlayer = ref(null);

const toggleMusic = () => {
    if (isPlaying.value) {
        audioPlayer.value.pause();
    } else {
        audioPlayer.value.play();
    }
    isPlaying.value = !isPlaying.value;
};

onMounted(() => {
    if (audioPlayer.value) {
        audioPlayer.value.volume = 0.4;
    }
});
</script>

<template>
    <Head title="Klaim Angpao Hoki 2026" />

    <RainingAngpao />

    <div class="min-h-screen bg-[#5c0000] relative overflow-hidden flex flex-col items-center justify-center p-6 font-sans">
        
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/oriental-tiles.png');"></div>
        <div class="absolute top-0 w-full h-64 bg-gradient-to-b from-black/50 to-transparent pointer-events-none"></div>

        <div class="relative z-10 w-full max-w-xl text-center">
            
            <div class="mb-12 animate-bounce-slow">
                <div class="inline-block relative">
                    <span class="text-8xl drop-shadow-[0_10px_20px_rgba(234,179,8,0.5)]">🧧</span>
                    <div class="absolute -top-4 -right-4 bg-yellow-500 text-red-900 text-xs font-black px-3 py-1 rounded-full shadow-lg border-2 border-white animate-pulse">
                        2026
                    </div>
                </div>
                <h1 class="text-5xl md:text-6xl font-black mt-6 tracking-tighter uppercase italic">
                    <span class="text-white">ANGPAO</span>
                    <span class="block text-transparent bg-clip-text bg-gradient-to-b from-yellow-200 to-yellow-500 drop-shadow-sm">HOKI BESAR</span>
                </h1>
                <p class="text-red-200/80 text-sm font-bold uppercase tracking-[0.4em] mt-3">Semoga Keberuntungan Menyertai Anda</p>
            </div>

            <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-[40px] p-8 md:p-12 shadow-2xl relative overflow-hidden group">
                <div class="absolute inset-4 border border-yellow-500/20 rounded-[30px] pointer-events-none group-hover:border-yellow-500/40 transition-colors"></div>

                <form @submit.prevent="submit" class="relative z-10 space-y-6">
                    <div>
                        <label class="block text-xs font-black text-yellow-500 uppercase tracking-widest mb-4">Masukkan Kode Rahasia</label>
                        <input
                            v-model="form.code"
                            type="text"
                            placeholder="CONTOH: HOKI88"
                            required
                            class="w-full bg-black/30 border-2 border-white/10 rounded-2xl px-6 py-5 text-center text-2xl font-black text-yellow-400 placeholder:text-white/10 focus:border-yellow-500 focus:ring-0 transition-all uppercase tracking-widest"
                        />
                        
                        <Transition enter-from-class="opacity-0 -translate-y-2" class="transition">
                            <p v-if="$page.props.flash.error" class="mt-4 text-red-400 font-bold text-sm bg-red-950/50 py-2 rounded-xl border border-red-500/30 italic">
                                ⚠️ {{ $page.props.flash.error }}
                            </p>
                        </Transition>
                        <Transition enter-from-class="opacity-0 -translate-y-2" class="transition">
                            <p v-if="$page.props.flash.success" class="mt-4 text-green-400 font-bold text-sm bg-green-950/50 py-2 rounded-xl border border-green-500/30">
                                ✨ {{ $page.props.flash.success }}
                            </p>
                        </Transition>
                    </div>

                    <button
                        :disabled="form.processing"
                        class="w-full bg-gradient-to-b from-yellow-300 via-yellow-500 to-yellow-600 text-red-950 font-black py-5 rounded-2xl shadow-[0_8px_0_0_#854d0e] active:shadow-none active:translate-y-2 transition-all text-xl uppercase tracking-[0.2em] relative overflow-hidden group"
                    >
                        <span class="relative z-10">Buka Angpao Sekarang!</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent -translate-x-full group-hover:animate-shine"></div>
                    </button>
                </form>
            </div>

            <p class="mt-12 text-red-200/40 text-[10px] font-bold uppercase tracking-[0.3em]">
                Terbatas Untuk Keberuntungan Terpilih &bull; &copy; 2026
            </p>
        </div>

        <div class="fixed bottom-10 right-10 z-50">
            <button 
                @click="toggleMusic"
                class="w-16 h-16 bg-gradient-to-tr from-yellow-600 to-yellow-400 rounded-2xl shadow-2xl flex items-center justify-center text-3xl border-2 border-white/30 hover:scale-110 active:scale-90 transition-all duration-500 relative group"
            >
                <span v-if="isPlaying" class="absolute inset-0 rounded-2xl bg-yellow-400 animate-ping opacity-20"></span>
                <span :class="{'animate-spin-slow': isPlaying}">{{ isPlaying ? '🎵' : '🔇' }}</span>
                
                <span class="absolute right-full mr-4 px-4 py-2 bg-black/80 text-white text-[10px] font-bold uppercase tracking-widest rounded-xl opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                    {{ isPlaying ? 'Matikan Instrumen' : 'Putar Instrumen Hoki' }}
                </span>
            </button>
        </div>

        <audio ref="audioPlayer" loop src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"></audio>
    </div>
</template>

<style scoped>
@keyframes bounce-slow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}
.animate-bounce-slow {
    animation: bounce-slow 4s ease-in-out infinite;
}

@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
.animate-spin-slow {
    animation: spin-slow 8s linear infinite;
}

@keyframes shine {
    100% { transform: translateX(100%); }
}
.animate-shine {
    animation: shine 0.7s ease-in-out;
}
</style>