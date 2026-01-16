<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    code: '',
});

const submitClaim = () => {
    form.post(route('angpao.claim'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Imperial Fortune — Claim Access" />
    
    <div class="h-screen w-full bg-[#4A0000] flex flex-col items-center justify-center p-6 overflow-hidden relative">
        
        <div class="absolute inset-0 opacity-10 pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/chinese-lanterns.png')]"></div>
        
        <div class="absolute top-0 left-12 animate-bounce duration-[3000ms] text-6xl drop-shadow-2xl">🏮</div>
        <div class="absolute top-0 right-12 animate-bounce duration-[4000ms] text-6xl drop-shadow-2xl">🏮</div>
        <div class="absolute top-10 left-32 opacity-20 text-4xl hidden md:block">🏮</div>
        <div class="absolute top-10 right-32 opacity-20 text-4xl hidden md:block">🏮</div>

        <div class="absolute bottom-10 left-0 w-full flex justify-around opacity-20 text-7xl pointer-events-none select-none">
            <span>☁️</span><span>☁️</span><span>☁️</span><span>☁️</span><span>☁️</span>
        </div>

        <div class="fixed top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#D4AF37] via-[#F9E498] to-[#AA8A2E] z-50"></div>
        <div class="fixed bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#AA8A2E] via-[#F9E498] to-[#D4AF37] z-50"></div>

        <div class="max-w-md w-full relative z-10 space-y-10">
            <div class="text-center space-y-4">
                <div class="relative inline-block group">
                    <div class="absolute inset-0 bg-[#D4AF37] blur-[40px] opacity-30 scale-150 transition-opacity group-hover:opacity-50"></div>
                    <div class="w-28 h-28 bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] rounded-[2.5rem] flex items-center justify-center text-5xl shadow-[0_20px_50px_rgba(0,0,0,0.4)] mx-auto rotate-3 border-4 border-[#D4AF37] relative z-10 transition-transform hover:rotate-0 duration-700">
                        🧧
                    </div>
                </div>
                <div class="space-y-1">
                    <h1 class="text-3xl font-black tracking-[0.2em] uppercase leading-none text-transparent bg-clip-text bg-gradient-to-b from-[#F9E498] via-[#D4AF37] to-[#AA8A2E] drop-shadow-lg">
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
                        <div class="relative">
                            <input 
                                v-model="form.code" 
                                type="text" 
                                placeholder="MASUKKAN KODE"
                                class="w-full py-6 px-4 bg-[#4A0000]/60 border-2 border-[#D4AF37]/50 rounded-2xl text-center text-2xl font-black tracking-[0.3em] text-[#F9E498] uppercase placeholder:text-[#F9E498]/20 focus:bg-[#4A0000] focus:border-[#F9E498] focus:ring-8 focus:ring-[#D4AF37]/10 transition-all outline-none shadow-inner"
                                maxlength="15"
                                required
                            >
                        </div>
                    </div>

                    <button 
                        :disabled="form.processing"
                        class="w-full py-5 bg-gradient-to-r from-[#D4AF37] via-[#F9E498] to-[#D4AF37] text-[#4A0000] font-black text-[11px] uppercase tracking-[0.4em] rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.3)] hover:scale-[1.03] hover:shadow-[0_15px_40px_rgba(212,175,55,0.4)] active:scale-95 transition-all duration-300 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Verifying...' : 'Claim Fortune 🧧' }}
                    </button>
                </form>

                <div class="absolute -right-8 -bottom-8 text-[10rem] opacity-[0.05] rotate-12 pointer-events-none group-hover:rotate-0 transition-transform duration-1000">🧧</div>
            </div>

            <div class="text-center">
                <p class="text-[8px] font-black text-[#D4AF37] uppercase tracking-[0.4em] leading-relaxed opacity-60">
                    Secured by Imperial Palace Guard <br>
                    Authenticity Guaranteed &bull; Imlek 2026
                </p>
            </div>
        </div>

        <div class="absolute top-1/4 -left-20 w-80 h-80 bg-red-600 rounded-full blur-[120px] opacity-20"></div>
        <div class="absolute bottom-1/4 -right-20 w-80 h-80 bg-[#D4AF37] rounded-full blur-[120px] opacity-10"></div>
    </div>
</template>

<style>
/* Reset dasar untuk layar tetap */
body {
    margin: 0;
    padding: 0;
    background-color: #4A0000;
    overflow: hidden; /* Mencegah scroll di level body */
}

/* Animasi lampion bergoyang */
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}

.animate-bounce {
    animation: bounce linear infinite;
}

input::placeholder {
    letter-spacing: normal;
    text-transform: uppercase;
}
</style>