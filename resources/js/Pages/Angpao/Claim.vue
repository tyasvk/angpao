<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import RainingAngpao from '@/Components/RainingAngpao.vue';

const props = defineProps({ status: String });
const page = usePage();
const flashSuccess = computed(() => page.props.flash?.success);
const flashError = computed(() => page.props.flash?.error);

const form = useForm({ code: '' });
const submit = () => {
    form.post(route('angpao.claim'), {
        onSuccess: () => form.reset(),
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Imperial Angpao 2026" />

    <RainingAngpao />

    <div class="royal-wrapper h-screen w-full flex flex-col items-center justify-center relative overflow-hidden font-serif p-4">
        
        <div class="absolute inset-0 silk-pattern opacity-15 pointer-events-none"></div>
        <div class="absolute inset-0 gold-glow-ambient pointer-events-none"></div>

        <div class="absolute top-[-20px] left-[10%] animate-sway pointer-events-none hidden xl:block">
            <div class="rope"></div>
            <div class="lantern-imperial">
                <div class="lantern-light"></div>
                <div class="lantern-txt">福</div>
            </div>
        </div>
        <div class="absolute top-[-40px] right-[10%] animate-sway-slow pointer-events-none hidden xl:block">
            <div class="rope"></div>
            <div class="lantern-imperial small">
                <div class="lantern-light"></div>
                <div class="lantern-txt text-2xl">🧧</div>
            </div>
        </div>

        <div class="screen-corner top-6 left-6 border-t-2 border-l-2"></div>
        <div class="screen-corner top-6 right-6 border-t-2 border-r-2"></div>
        <div class="screen-corner bottom-6 left-6 border-b-2 border-l-2"></div>
        <div class="screen-corner bottom-6 right-6 border-b-2 border-r-2"></div>

        <div class="relative z-10 w-full max-w-[500px] flex flex-col items-center justify-center">
            
            <div class="text-center mb-6 md:mb-10 animate-fade-in">
                <div class="relative inline-block mb-4">
                    <span class="text-7xl md:text-8xl drop-shadow-[0_15px_30px_rgba(0,0,0,0.6)] leading-none block">🧧</span>
                    <div class="absolute -bottom-1 -right-3 bg-gradient-to-r from-yellow-500 to-yellow-300 text-red-950 text-[10px] font-black px-3 py-1 rounded-full border border-white shadow-xl rotate-12">
                        LUNAR 2026
                    </div>
                </div>
                
                <h1 class="text-4xl md:text-5xl font-black tracking-tighter italic gold-metallic-text uppercase leading-none drop-shadow-2xl">
                    FORTUNE ACCESS
                </h1>
                <p class="mt-3 text-yellow-500/60 text-[10px] font-bold uppercase tracking-[0.5em] drop-shadow">Imperial Treasury</p>
            </div>

            <div class="w-full relative group">
                <div class="absolute inset-0 bg-yellow-500/10 blur-[50px] rounded-full scale-75 group-hover:bg-yellow-500/20 transition-all duration-1000"></div>

                <div class="relative bg-[#1a0000]/90 backdrop-blur-3xl border-2 border-yellow-600/40 rounded-[3rem] p-1 shadow-[0_40px_100px_rgba(0,0,0,0.8)] overflow-hidden">
                    
                    <div class="absolute inset-4 border border-yellow-600/20 rounded-[2.5rem] pointer-events-none"></div>
                    
                    <div class="p-8 md:p-12 relative z-10">
                        <form @submit.prevent="submit" class="space-y-8">
                            <div class="space-y-4 text-center">
                                <label class="text-[10px] font-black text-yellow-500/50 uppercase tracking-[0.4em] block">Security Seal Code</label>
                                
                                <div class="relative flex items-center justify-center">
                                    <span class="absolute left-0 text-2xl opacity-20 text-yellow-500">🐉</span>
                                    <input
                                        v-model="form.code"
                                        type="text"
                                        placeholder="KODE HOKI"
                                        required
                                        class="w-full bg-transparent border-b-2 border-yellow-800 focus:border-yellow-400 text-center text-3xl font-bold text-yellow-400 placeholder:text-red-950 py-4 focus:ring-0 transition-all uppercase tracking-[0.2em]"
                                    />
                                    <span class="absolute right-0 text-2xl opacity-20 text-yellow-500 scale-x-[-1]">🐉</span>
                                </div>
                            </div>

                            <button
                                :disabled="form.processing"
                                class="w-full py-5 bg-gradient-to-b from-yellow-300 via-yellow-500 to-yellow-600 text-red-950 font-black text-lg uppercase tracking-[0.3em] rounded-2xl shadow-[0_10px_0_#854d0e] active:shadow-none active:translate-y-2 transition-all duration-150 overflow-hidden relative group/btn"
                            >
                                <span class="relative z-10 drop-shadow-sm">BUKA ANGPAO 🏮</span>
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/50 to-transparent -translate-x-full group-hover/btn:animate-shine"></div>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="absolute -bottom-16 left-0 w-full flex justify-center px-4">
                    <Transition enter-from-class="opacity-0 translate-y-2" class="transition-all duration-300">
                        <div v-if="flashError" class="bg-white/95 text-red-700 px-6 py-2 rounded-full text-[10px] font-black shadow-2xl border-2 border-red-600 uppercase italic">
                            ⚠️ {{ flashError }}
                        </div>
                    </Transition>
                    <Transition enter-from-class="opacity-0 translate-y-2" class="transition-all duration-300">
                        <div v-if="flashSuccess" class="bg-yellow-400 text-red-900 px-6 py-2 rounded-full text-[10px] font-black shadow-2xl border-2 border-white uppercase tracking-widest">
                            🧧 {{ flashSuccess }}
                        </div>
                    </Transition>
                </div>
            </div>

            <p class="mt-12 text-yellow-900/30 text-[9px] font-bold uppercase tracking-[0.6em] pointer-events-none">
                © 2026 Prosperity Dynasty
            </p>
        </div>
    </div>
</template>

<style scoped>
/* BACKGROUND MASTER */
.royal-wrapper {
    background: #4a0000 !important;
    background: radial-gradient(circle at center, #8b0000 0%, #4a0000 60%, #1a0000 100%) !important;
}

.silk-pattern {
    background-image: url('https://www.transparenttextures.com/patterns/oriental-tiles.png');
}

.gold-glow-ambient {
    background: radial-gradient(circle at center, rgba(253, 224, 71, 0.08) 0%, transparent 75%);
}

.gold-metallic-text {
    background: linear-gradient(to bottom, #fff7cc 0%, #d4af37 50%, #996515 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.5));
}

/* ORNAMEN SUDUT */
.screen-corner {
    position: absolute;
    width: 80px;
    height: 80px;
    border-color: rgba(212, 175, 55, 0.2);
    pointer-events: none;
}

/* LAMPION IMPERIAL */
.rope { width: 2px; height: 100px; background: #d4af37; margin: 0 auto; }
.lantern-imperial {
    width: 90px; height: 120px;
    background: linear-gradient(to right, #991b1b, #ef4444, #991b1b);
    border-radius: 40px; position: relative;
    border: 2px solid #d4af3780;
    box-shadow: 0 15px 40px rgba(0,0,0,0.6);
    display: flex; align-items: center; justify-content: center;
}
.lantern-imperial.small { width: 70px; height: 95px; }
.lantern-txt { color: #fde047; font-size: 2.5rem; font-weight: 900; }
.lantern-light {
    position: absolute; inset: 10%; background: radial-gradient(circle at center, rgba(253, 224, 71, 0.4) 0%, transparent 70%);
}

/* ANIMASI */
@keyframes sway { 0% { transform: rotate(-3deg); } 100% { transform: rotate(3deg); } }
.animate-sway { animation: sway 4s ease-in-out infinite alternate; transform-origin: top center; }
.animate-sway-slow { animation: sway 6s ease-in-out infinite alternate-reverse; transform-origin: top center; }

@keyframes shine { 100% { transform: translateX(100%); } }
.animate-shine { animation: shine 1.2s ease-in-out; }

@keyframes fade-in {
    from { opacity: 0; transform: scale(0.95) translateY(20px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.animate-fade-in { animation: fade-in 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
</style>