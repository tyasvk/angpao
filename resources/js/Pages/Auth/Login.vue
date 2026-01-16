<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: { type: Boolean },
    status: { type: String },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Fortune Access - Login" />

    <div class="h-screen w-full flex flex-col items-center justify-center bg-[#F8F9FA] relative overflow-hidden font-sans p-4 text-slate-800">
        
        <div class="absolute inset-0 silk-pattern opacity-[0.02] pointer-events-none"></div>
        <div class="absolute top-[-15%] right-[-5%] w-[35%] h-[50%] bg-red-50 rounded-full blur-[100px] opacity-40"></div>
        <div class="absolute bottom-[-15%] left-[-5%] w-[35%] h-[50%] bg-red-50 rounded-full blur-[100px] opacity-40"></div>

        <div class="relative z-10 w-full max-w-[380px] flex flex-col items-center justify-center gap-4">
            
            <div class="text-center animate-fade-in">
                <div class="inline-block relative mb-1">
                    <div class="w-12 h-12 bg-red-700 rounded-xl flex items-center justify-center text-white text-2xl shadow-lg shadow-red-100 rotate-2">
                        🧧
                    </div>
                </div>
                <h1 class="text-xl md:text-2xl font-black tracking-tighter text-slate-900 uppercase">
                    FORTUNE <span class="text-red-700 italic">ACCESS</span>
                </h1>
                <p class="text-[8px] text-slate-400 font-bold uppercase tracking-[0.4em]">Secure Portal</p>
            </div>

            <div class="w-full bg-white rounded-[2rem] shadow-[0_20px_40px_rgba(0,0,0,0.05)] border border-slate-100 p-6 md:p-8 relative overflow-hidden">
                
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-700 via-[#D4AF37] to-red-700 opacity-80"></div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest ml-1">Imperial Credentials</label>
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="Email Institusi"
                            required
                            autofocus
                            class="w-full bg-slate-50 border border-slate-100 rounded-lg py-3 px-4 text-xs text-slate-700 placeholder:text-slate-300 focus:bg-white focus:ring-2 focus:ring-red-700/5 focus:border-red-700 transition-all outline-none"
                        />
                        <div v-if="form.errors.email" class="text-red-600 text-[9px] font-bold italic mt-0.5">{{ form.errors.email }}</div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest ml-1">Security Key</label>
                        <input
                            v-model="form.password"
                            type="password"
                            placeholder="••••••••"
                            required
                            class="w-full bg-slate-50 border border-slate-100 rounded-lg py-3 px-4 text-xs text-slate-700 placeholder:text-slate-300 focus:bg-white focus:ring-2 focus:ring-red-700/5 focus:border-red-700 transition-all outline-none"
                        />
                        <div v-if="form.errors.password" class="text-red-600 text-[9px] font-bold italic mt-0.5">{{ form.errors.password }}</div>
                    </div>

                    <div class="flex items-center justify-between px-1">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" v-model="form.remember" class="rounded-sm border-slate-200 text-red-700 focus:ring-red-700 h-3 w-3 shadow-sm transition-all" />
                            <span class="ml-2 text-[9px] font-bold text-slate-400 uppercase group-hover:text-red-700 transition-colors">Ingat Sesi</span>
                        </label>
                        <Link v-if="canResetPassword" :href="route('password.request')" class="text-[9px] font-bold text-red-700 uppercase hover:text-red-800 underline-offset-4 hover:underline">
                            Lupa?
                        </Link>
                    </div>

                    <button
                        :disabled="form.processing"
                        class="w-full py-3.5 bg-red-700 text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-lg shadow-lg shadow-red-100 hover:bg-red-800 hover:scale-[1.01] active:scale-[0.98] transition-all duration-200"
                    >
                        Masuk Sistem
                    </button>
                </form>
            </div>

            <p class="text-slate-300 text-[7px] font-bold uppercase tracking-[0.6em] pointer-events-none">
                © 2026 Prosperity Management
            </p>
        </div>
    </div>
</template>

<style scoped>
.silk-pattern {
    background-image: url('https://www.transparenttextures.com/patterns/oriental-tiles.png');
}

@keyframes fade-in {
    from { opacity: 0; transform: scale(0.98); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fade-in {
    animation: fade-in 0.8s ease-out forwards;
}

input:focus {
    outline: none;
}
</style>