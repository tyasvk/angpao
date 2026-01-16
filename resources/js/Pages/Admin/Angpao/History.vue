<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

// Menerima data asli dari database
const props = defineProps({
    history: Object
});

const currentLang = ref('id');

const translations = {
    id: {
        title: 'Riwayat Klaim',
        subtitle: 'Audit Keberuntungan Kerajaan',
        table: {
            user: 'Penerima (User)',
            code: 'Kode Segel',
            reward: 'Hadiah',
            time: 'Waktu Klaim'
        },
        empty: 'Belum ada riwayat keberuntungan.',
        nav: {
            overview: 'Ringkasan Utama',
            master: 'Gudang Voucher',
            issue: 'Rilis Angpao',
            logs: 'Riwayat Klaim'
        }
    },
    en: {
        title: 'Royal Logs',
        subtitle: 'Imperial Fortune Audit',
        table: {
            user: 'Lucky User',
            code: 'Voucher Code',
            reward: 'Reward Granted',
            time: 'Claim Time'
        },
        empty: 'No fortune logs found yet.',
        nav: {
            overview: 'Overview Hall',
            master: 'Master Vault',
            issue: 'Grant Fortune',
            logs: 'Royal Logs'
        }
    }
};

const toggleLang = () => {
    currentLang.value = currentLang.value === 'id' ? 'en' : 'id';
};
</script>

<template>
    <Head :title="translations[currentLang].title + ' — Imperial Admin'" />

    <div class="h-screen w-full bg-[#4A0000] flex overflow-hidden font-sans text-[#F9E498]">
        
        <aside class="w-72 bg-gradient-to-b from-[#990000] to-[#4A0000] flex flex-col h-full border-r-4 border-[#D4AF37] shadow-2xl relative shrink-0">
            <div class="absolute inset-0 opacity-5 pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/chinese-lanterns.png')]"></div>
            <div class="p-8 border-b border-[#D4AF37]/30 flex flex-col items-center relative z-10">
                <div class="w-16 h-16 bg-[#D4AF37] rounded-2xl flex items-center justify-center text-4xl shadow-lg mb-4 rotate-3 border-2 border-[#F9E498]">🧧</div>
                <h2 class="text-lg font-black tracking-[0.2em] uppercase text-center leading-tight bg-clip-text text-transparent bg-gradient-to-b from-[#FFF3B0] to-[#D4AF37]">
                    Imperial Admin
                </h2>
                <p class="text-[9px] font-black text-[#F9E498] uppercase tracking-[0.3em] mt-2 opacity-80 text-center">Fortune Access</p>
            </div>
            
            <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scroll relative z-10">
                <Link :href="route('admin.dashboard')" class="lunar-nav">
                    <span>📊</span> <span class="ml-3">{{ translations[currentLang].nav.overview }}</span>
                </Link>
                <Link :href="route('admin.angpao.index')" class="lunar-nav">
                    <span>📜</span> <span class="ml-3">{{ translations[currentLang].nav.master }}</span>
                </Link>
                <Link :href="route('admin.angpao.create')" class="lunar-nav">
                    <span>👑</span> <span class="ml-3">{{ translations[currentLang].nav.issue }}</span>
                </Link>
                <Link :href="route('admin.angpao.history')" class="lunar-nav active">
                    <span>⌛</span> <span class="ml-3">{{ translations[currentLang].nav.logs }}</span>
                </Link>
            </nav>

            <div class="p-6 border-t border-[#D4AF37]/30 z-10">
                <Link :href="route('logout')" method="post" as="button" class="w-full flex items-center px-6 py-4 text-[10px] font-black uppercase tracking-[0.3em] text-[#F9E498] opacity-50 hover:opacity-100 transition-all">
                    🚪 Leave Palace
                </Link>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 relative">
            
            <header class="h-24 bg-[#660000] border-b-4 border-[#D4AF37] px-10 flex items-center justify-between shadow-2xl shrink-0">
                <div class="relative z-10">
                    <h1 class="text-2xl font-black tracking-widest uppercase bg-clip-text text-transparent bg-gradient-to-b from-[#FFF3B0] to-[#D4AF37]">
                        {{ translations[currentLang].title }}
                    </h1>
                    <p class="text-[10px] font-black uppercase tracking-[0.4em] text-[#F9E498] opacity-60">
                        {{ translations[currentLang].subtitle }}
                    </p>
                </div>

                <div class="flex items-center gap-6 relative z-10">
                    <button @click="toggleLang" class="px-4 py-2 border-2 border-[#D4AF37] rounded-xl text-[10px] font-black uppercase tracking-widest bg-[#4A0000] hover:bg-[#D4AF37] hover:text-[#4A0000] transition-all">
                        {{ currentLang === 'id' ? 'ID 🇮🇩' : 'EN 🇺🇸' }}
                    </button>
                    <div class="w-12 h-12 rounded-full border-2 border-[#D4AF37] flex items-center justify-center bg-[#4A0000] text-xl shadow-lg">👑</div>
                </div>
            </header>

            <div class="flex-1 p-10 overflow-hidden flex flex-col">
                <div class="flex-1 bg-[#660000]/40 border-4 border-[#D4AF37] rounded-[3rem] p-8 shadow-2xl flex flex-col relative overflow-hidden">
                    <div class="absolute inset-0 opacity-[0.03] pointer-events-none flex items-center justify-center text-[15rem]">💮</div>
                    
                    <div class="flex-1 overflow-y-auto custom-scroll pr-4 relative z-10">
                        <table class="w-full text-left">
                            <thead class="sticky top-0 bg-[#610000] z-10">
                                <tr class="text-[10px] font-black uppercase tracking-[0.3em] text-[#D4AF37]/60 border-b border-[#D4AF37]/20">
                                    <th class="py-6 px-4">{{ translations[currentLang].table.user }}</th>
                                    <th class="py-6 px-4">{{ translations[currentLang].table.code }}</th>
                                    <th class="py-6 px-4">{{ translations[currentLang].table.reward }}</th>
                                    <th class="py-6 px-4 text-right">{{ translations[currentLang].table.time }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-black uppercase">
                                <tr v-for="h in props.history.data" :key="h.id" class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-all group">
                                    <td class="py-6 px-4 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-[#4A0000] border border-[#D4AF37] flex items-center justify-center text-[10px]">👤</div>
                                        <span class="tracking-widest">{{ h.user?.name || 'Guest User' }}</span>
                                    </td>
                                    <td class="py-6 px-4 opacity-60 font-mono tracking-widest">{{ h.code }}</td>
                                    <td class="py-6 px-4">
                                        <span class="bg-[#4A0000] px-4 py-2 rounded-xl border border-[#D4AF37] text-[#D4AF37] shadow-inner inline-flex items-center gap-2">
                                            <span>{{ h.reward_type === 'money' ? '💰' : '🎁' }}</span>
                                            {{ h.reward_name }}
                                        </span>
                                    </td>
                                    <td class="py-6 px-4 text-right text-[10px] opacity-40">
                                        {{ h.claimed_at }}
                                    </td>
                                </tr>
                                <tr v-if="props.history.data.length === 0">
                                    <td colspan="4" class="py-32 text-center opacity-30 uppercase tracking-[0.5em] font-black">
                                        {{ translations[currentLang].empty }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="shrink-0 bg-[#660000] border-t-2 border-[#D4AF37] p-6 flex justify-center gap-3 relative z-10">
                        <Link v-for="link in props.history.links" :key="link.label" :href="link.url || '#'" v-html="link.label" 
                              class="px-5 py-2.5 rounded-2xl text-[10px] font-black uppercase transition-all"
                              :class="[
                                  link.active ? 'bg-[#D4AF37] text-[#4A0000] shadow-lg scale-105' : 'bg-[#4A0000] text-[#D4AF37] border border-[#D4AF37]/30 hover:bg-[#D4AF37]/10',
                                  !link.url ? 'opacity-20 cursor-not-allowed' : ''
                              ]"
                        />
                    </div>
                </div>
            </div>

            <div class="absolute bottom-4 right-10 text-8xl opacity-10 pointer-events-none select-none rotate-12">☁️</div>
        </main>
    </div>
</template>

<style scoped>
.lunar-nav {
    @apply flex items-center px-6 py-4 text-[11px] font-black uppercase tracking-[0.3em] text-[#F9E498]/60 rounded-xl transition-all duration-300;
}
.lunar-nav.active { @apply bg-gradient-to-r from-[#D4AF37] to-[#AA8A2E] text-[#4A0000] shadow-xl font-black; }

.custom-scroll::-webkit-scrollbar { width: 6px; }
.custom-scroll::-webkit-scrollbar-thumb { background: #D4AF37; border-radius: 10px; }

:global(body) { 
    overflow: hidden; 
    background-color: #4A0000;
}
* { font-style: normal !important; }
</style>