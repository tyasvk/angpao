<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    stats: Object,
    recentClaims: Array
});
</script>

<template>
    <AdminLayout title="Pusat Komando">
        <template #header>
            <div>
                <h1 class="text-2xl font-black tracking-widest uppercase bg-clip-text text-transparent bg-gradient-to-b from-[#FFF3B0] to-[#D4AF37]">
                    Pusat Komando
                </h1>
                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-[#F9E498] opacity-60">
                    Ikhtisar Keberuntungan Kerajaan
                </p>
            </div>
        </template>

        <div class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div v-for="(val, key) in stats" :key="key" 
                     class="bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] border-2 border-[#D4AF37] rounded-[2rem] p-6 shadow-xl relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 text-6xl opacity-10 group-hover:scale-125 transition-transform duration-700">🧧</div>
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-[#F9E498] mb-1 opacity-70">{{ key.replace('_', ' ') }}</p>
                    <h3 class="text-2xl font-black tracking-tighter text-white">{{ val }}</h3>
                </div>
            </div>

            <div class="bg-[#660000]/40 border-4 border-[#D4AF37] rounded-[3rem] p-8 shadow-2xl relative overflow-hidden">
                <div class="absolute inset-0 opacity-[0.03] pointer-events-none flex items-center justify-center text-[15rem]">💮</div>
                <h3 class="text-xs font-black uppercase tracking-[0.5em] text-[#F9E498] mb-6 border-b border-[#D4AF37]/20 pb-4">
                    🏮 Aktivitas Klaim Terbaru
                </h3>
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black uppercase tracking-[0.3em] text-[#D4AF37]/60 border-b border-[#D4AF37]/20">
                            <th class="py-4">User</th>
                            <th class="py-4">Hadiah</th>
                            <th class="py-4 text-right">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm font-black">
                        <tr v-for="claim in recentClaims" :key="claim.id" class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-all">
                            <td class="py-5 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#4A0000] border border-[#D4AF37] flex items-center justify-center text-[10px]">👤</div>
                                <span class="uppercase tracking-widest text-[#F9E498]">{{ claim.user?.name || 'Guest' }}</span>
                            </td>
                            <td class="py-5">
                                <span class="bg-[#4A0000] px-4 py-1.5 rounded-full border border-[#D4AF37] text-[#D4AF37] text-[10px] uppercase">
                                    {{ claim.reward_name }} 🧧
                                </span>
                            </td>
                            <td class="py-5 text-right text-[10px] opacity-40 uppercase tracking-widest">{{ claim.claimed_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>