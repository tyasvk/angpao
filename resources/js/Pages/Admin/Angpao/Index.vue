<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';

const props = defineProps({
    angpaos: Object,
    filters: Object
});

const currentLang = ref('id');
const search = ref(props.filters?.search || '');
const statusFilter = ref(props.filters?.status || '');
const selectedIds = ref([]);

const translations = {
    id: {
        title: 'Gudang Voucher',
        subtitle: 'Manajemen Segel Rahasia',
        search: 'Cari Kode...',
        filter_status: 'Semua Status',
        status_active: 'Aktif',
        status_claimed: 'Terklaim',
        delete_sel: 'Hapus Terpilih',
        table: { code: 'Kode Voucher', status: 'Status', action: 'Aksi' },
        nav: { overview: 'Ringkasan Utama', master: 'Gudang Voucher', issue: 'Rilis Angpao', logs: 'Riwayat Klaim' }
    },
    en: {
        title: 'Master Vault',
        subtitle: 'Secret Decree Management',
        search: 'Search Code...',
        filter_status: 'All Status',
        status_active: 'Active',
        status_claimed: 'Claimed',
        delete_sel: 'Delete Selected',
        table: { code: 'Voucher Code', status: 'Status', action: 'Actions' },
        nav: { overview: 'Overview Hall', master: 'Master Vault', issue: 'Grant Fortune', logs: 'Royal Logs' }
    }
};

const toggleLang = () => {
    currentLang.value = currentLang.value === 'id' ? 'en' : 'id';
};

// Logika Filter (Search & Status)
watch([search, statusFilter], ([newSearch, newStatus]) => {
    router.get(route('admin.angpao.index'), { 
        search: newSearch, 
        status: newStatus 
    }, { 
        preserveState: true, 
        replace: true 
    });
});

const selectAll = computed({
    get: () => props.angpaos.data.length > 0 && selectedIds.value.length === props.angpaos.data.length,
    set: (val) => selectedIds.value = val ? props.angpaos.data.map(a => a.id) : []
});

const deleteSingle = (id) => {
    if (confirm('Hapus voucher ini?')) router.delete(route('admin.angpao.destroy', id));
};
</script>

<template>
    <Head :title="translations[currentLang].title + ' — Imperial Admin'" />

    <div class="h-screen w-full bg-[#4A0000] flex overflow-hidden font-sans text-[#F9E498]">
        
        <aside class="w-72 bg-gradient-to-b from-[#990000] to-[#4A0000] flex flex-col h-full border-r-4 border-[#D4AF37] shadow-2xl shrink-0 relative">
            <div class="absolute inset-0 opacity-5 pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/chinese-lanterns.png')]"></div>
            <div class="p-8 border-b border-[#D4AF37]/30 flex flex-col items-center relative z-10">
                <div class="w-16 h-16 bg-[#D4AF37] rounded-2xl flex items-center justify-center text-4xl shadow-lg mb-4 rotate-3 border-2 border-[#F9E498]">🧧</div>
                <h2 class="text-lg font-black tracking-[0.2em] uppercase text-center leading-tight bg-clip-text text-transparent bg-gradient-to-b from-[#FFF3B0] to-[#D4AF37]">Imperial Admin</h2>
                <p class="text-[9px] font-black text-[#F9E498] uppercase tracking-[0.3em] mt-2 opacity-80 text-center">Fortune Access</p>
            </div>
            <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scroll relative z-10">
                <Link :href="route('admin.dashboard')" class="lunar-nav"><span>📊</span> <span class="ml-3">{{ translations[currentLang].nav.overview }}</span></Link>
                <Link :href="route('admin.angpao.index')" class="lunar-nav active"><span>📜</span> <span class="ml-3">{{ translations[currentLang].nav.master }}</span></Link>
                <Link :href="route('admin.angpao.create')" class="lunar-nav"><span>👑</span> <span class="ml-3">{{ translations[currentLang].nav.issue }}</span></Link>
                <Link :href="route('admin.angpao.history')" class="lunar-nav"><span>⌛</span> <span class="ml-3">{{ translations[currentLang].nav.logs }}</span></Link>
            </nav>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 relative">
            
            <header class="h-24 bg-[#660000] border-b-4 border-[#D4AF37] px-10 flex items-center justify-between shadow-2xl shrink-0 z-20">
                <div>
                    <h1 class="text-2xl font-black tracking-widest uppercase bg-clip-text text-transparent bg-gradient-to-b from-[#FFF3B0] to-[#D4AF37]">{{ translations[currentLang].title }}</h1>
                    <p class="text-[10px] font-black uppercase tracking-[0.4em] text-[#F9E498] opacity-60">{{ translations[currentLang].subtitle }}</p>
                </div>

                <div class="flex items-center gap-4 relative z-10">
                    <select v-model="statusFilter" class="bg-[#4A0000] border-2 border-[#D4AF37] rounded-xl px-4 py-2 text-[10px] font-black uppercase text-[#F9E498] outline-none focus:ring-4 focus:ring-[#D4AF37]/20">
                        <option value="">{{ translations[currentLang].filter_status }}</option>
                        <option value="active">{{ translations[currentLang].status_active }}</option>
                        <option value="claimed">{{ translations[currentLang].status_claimed }}</option>
                    </select>

                    <div class="relative">
                        <input v-model="search" type="text" :placeholder="translations[currentLang].search" class="pl-10 pr-4 py-2 bg-[#4A0000] border-2 border-[#D4AF37] rounded-xl text-xs text-[#F9E498] outline-none w-64 font-black">
                        <span class="absolute left-3 top-2.5 opacity-30 text-xs">🔍</span>
                    </div>

                    <button @click="toggleLang" class="px-4 py-2 border-2 border-[#D4AF37] rounded-xl text-[10px] font-black uppercase tracking-widest bg-[#4A0000] hover:bg-[#D4AF37] hover:text-[#4A0000] transition-all">{{ currentLang === 'id' ? 'ID 🇮🇩' : 'EN 🇺🇸' }}</button>
                    <div class="w-12 h-12 rounded-full border-2 border-[#D4AF37] flex items-center justify-center bg-[#4A0000] text-xl shadow-lg">👑</div>
                </div>
            </header>

            <div class="flex-1 p-8 overflow-hidden flex flex-col">
                <div class="flex-1 bg-[#660000]/40 border-4 border-[#D4AF37] rounded-[3rem] p-8 shadow-2xl flex flex-col relative overflow-hidden">
                    
                    <div class="flex-1 overflow-y-auto custom-scroll pr-2 relative z-10">
                        <table class="w-full text-left">
                            <thead class="sticky top-0 bg-[#610000] z-20">
                                <tr class="text-[10px] font-black uppercase tracking-[0.3em] text-[#D4AF37]/60 border-b border-[#D4AF37]/20">
                                    <th class="py-4 px-4 w-10"><input type="checkbox" v-model="selectAll" class="rounded border-[#D4AF37] bg-[#4A0000] text-[#D4AF37] focus:ring-[#D4AF37]"></th>
                                    <th class="py-4">{{ translations[currentLang].table.code }}</th>
                                    <th class="py-4 text-center">{{ translations[currentLang].table.status }}</th>
                                    <th class="py-4 text-right px-4">{{ translations[currentLang].table.action }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-black uppercase tracking-widest">
                                <tr v-for="a in angpaos.data" :key="a.id" class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-all">
                                    <td class="py-5 px-4"><input type="checkbox" :value="a.id" v-model="selectedIds" class="rounded border-[#D4AF37] bg-[#4A0000] text-[#D4AF37] focus:ring-[#D4AF37]"></td>
                                    <td class="py-5"><span class="bg-[#4A0000] px-4 py-2 rounded-xl border border-[#D4AF37]">{{ a.code }}</span></td>
                                    <td class="py-5 text-center">
                                        <span :class="a.status === 'active' ? 'bg-[#D4AF37] text-[#4A0000]' : 'opacity-40'" class="px-4 py-1.5 rounded-full text-[9px] border border-[#F9E498]/30">
                                            {{ a.status }}
                                        </span>
                                    </td>
                                    <td class="py-5 text-right px-4">
                                        <button @click="deleteSingle(a.id)" class="text-xl hover:scale-125 transition-transform">🗑️</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="shrink-0 bg-[#660000] border-t-2 border-[#D4AF37] p-6 flex justify-center gap-2 relative z-10">
                        <Link v-for="link in angpaos.links" :key="link.label" :href="link.url || '#'" v-html="link.label" 
                              class="px-4 py-2 rounded-xl text-[10px] font-black uppercase transition-all"
                              :class="[
                                  link.active ? 'bg-[#D4AF37] text-[#4A0000] shadow-lg scale-105' : 'bg-[#4A0000] text-[#D4AF37] border border-[#D4AF37]/30 hover:bg-[#D4AF37]/10',
                                  !link.url ? 'opacity-20 cursor-not-allowed' : ''
                              ]"
                        />
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>
.lunar-nav { @apply flex items-center px-6 py-4 text-[11px] font-black uppercase tracking-[0.3em] text-[#F9E498]/60 rounded-xl transition-all duration-300; }
.lunar-nav:hover { @apply bg-[#D4AF37]/10 text-[#F9E498]; }
.lunar-nav.active { @apply bg-gradient-to-r from-[#D4AF37] to-[#AA8A2E] text-[#4A0000] shadow-xl font-black; }

.custom-scroll::-webkit-scrollbar { width: 6px; }
.custom-scroll::-webkit-scrollbar-track { background: #4A0000; border-radius: 10px; }
.custom-scroll::-webkit-scrollbar-thumb { background: #D4AF37; border-radius: 10px; }

:global(body) { overflow: hidden; background-color: #4A0000; }
* { font-style: normal !important; }
</style>