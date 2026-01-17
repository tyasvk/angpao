<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({ history: Object });
</script>

<template>
    <AdminLayout title="Riwayat Klaim">
        <template #header>
            <div>
                <h1 class="text-2xl font-black tracking-widest uppercase bg-clip-text text-transparent bg-gradient-to-b from-[#FFF3B0] to-[#D4AF37]">
                    Riwayat Klaim
                </h1>
                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-[#F9E498] opacity-60">Audit Keberuntungan Kerajaan</p>
            </div>
        </template>

        <div class="bg-[#660000]/40 border-4 border-[#D4AF37] rounded-[3rem] p-8 shadow-2xl relative overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black uppercase tracking-[0.3em] text-[#D4AF37]/60 border-b border-[#D4AF37]/20">
                        <th class="py-6 px-4">Penerima</th>
                        <th class="py-6 px-4">Kode</th>
                        <th class="py-6 px-4">Hadiah</th>
                        <th class="py-6 px-4 text-right">Waktu</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-black uppercase">
                    <tr v-for="h in history.data" :key="h.id" class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-all">
                        <td class="py-6 px-4 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#4A0000] border border-[#D4AF37] flex items-center justify-center text-[10px]">👤</div>
                            <span class="tracking-widest">{{ h.user?.name || 'Guest' }}</span>
                        </td>
                        <td class="py-6 px-4 opacity-60 font-mono tracking-widest">{{ h.code }}</td>
                        <td class="py-6 px-4">
                            <span class="bg-[#4A0000] px-4 py-2 rounded-xl border border-[#D4AF37] text-[#D4AF37] text-[10px] inline-flex items-center gap-2">
                                <span>{{ h.reward_type === 'money' ? '💰' : '🎁' }}</span> {{ h.reward_name }}
                            </span>
                        </td>
                        <td class="py-6 px-4 text-right text-[10px] opacity-40">{{ h.claimed_at }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-8 flex justify-center gap-2 pb-4">
                <Link v-for="link in history.links" :key="link.label" :href="link.url || '#'" v-html="link.label" 
                      class="px-4 py-2 rounded-xl text-[9px] font-black transition-all"
                      :class="link.active ? 'bg-[#D4AF37] text-[#4A0000]' : 'bg-[#4A0000] text-[#D4AF37] border border-[#D4AF37]/30 hover:bg-[#D4AF37]/10'"/>
            </div>
        </div>
    </AdminLayout>
</template>