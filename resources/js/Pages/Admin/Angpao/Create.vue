<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const currentLang = ref('id');

const form = useForm({
    prefix: 'LUNAR-',
    expires_at: '',
    rewards: [
        { type: 'money', value: '', quantity: 1, image: null, preview: null }
    ]
});

const translations = {
    id: {
        title: 'Issue Fortune',
        subtitle: 'Penerbitan Segel Keberuntungan Kerajaan',
        config_title: '1. Konfigurasi Kunci Utama',
        reward_title: '2. Manifes Hadiah Kerajaan',
        labels: {
            prefix: 'Prefix Kode',
            expiry: 'Masa Berlaku',
            add: 'TAMBAH UNIT HADIAH BARU +',
            submit: 'SEGEL & TERBITKAN ANGPAO 🧧',
            th_img: 'Visual',
            th_type: 'Kategori',
            th_val: 'Nominal / Nama Unit',
            th_qty: 'Qty',
            th_act: 'Aksi'
        },
        types: { money: 'Tunai', item: 'Barang' },
        nav: {
            overview: 'Ringkasan Utama',
            master: 'Gudang Voucher',
            issue: 'Rilis Angpao Baru',
            logs: 'Riwayat Klaim'
        }
    },
    en: {
        title: 'Issue Fortune',
        subtitle: 'Imperial Voucher Issuance Protocol',
        config_title: '1. Master Key Configuration',
        reward_title: '2. Royal Reward Manifest',
        labels: {
            prefix: 'Code Prefix',
            expiry: 'Expiry Date',
            add: 'ADD NEW REWARD UNIT +',
            submit: 'SEAL & ISSUE FORTUNE 🧧',
            th_img: 'Visual',
            th_type: 'Category',
            th_val: 'Value / Name',
            th_qty: 'Qty',
            th_act: 'Act'
        },
        types: { money: 'Cash', item: 'Item' },
        nav: {
            overview: 'Overview Hall',
            master: 'Master Vault',
            issue: 'Grant New Fortune',
            logs: 'Royal Logs'
        }
    }
};

const toggleLang = () => {
    currentLang.value = currentLang.value === 'id' ? 'en' : 'id';
};

const addRow = () => {
    form.rewards.push({ type: 'money', value: '', quantity: 1, image: null, preview: null });
};

const removeRow = (i) => {
    if (form.rewards.length > 1) form.rewards.splice(i, 1);
};

const handleImg = (i, e) => {
    const file = e.target.files[0];
    if (file) {
        form.rewards[i].image = file;
        form.rewards[i].preview = URL.createObjectURL(file);
    }
};

const submit = () => {
    form.post(route('admin.angpao.store'), {
        forceFormData: true,
        onSuccess: () => form.reset(),
    });
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
                <Link :href="route('admin.angpao.create')" class="lunar-nav active">
                    <span>👑</span> <span class="ml-3">{{ translations[currentLang].nav.issue }}</span>
                </Link>
                <Link :href="route('admin.angpao.history')" class="lunar-nav">
                    <span>⌛</span> <span class="ml-3">{{ translations[currentLang].nav.logs }}</span>
                </Link>
            </nav>

            <div class="p-6 border-t border-[#D4AF37]/30 z-10">
                <button class="w-full flex items-center px-6 py-4 text-[10px] font-black uppercase tracking-[0.3em] text-[#F9E498] opacity-50 hover:opacity-100 transition-all font-sans">
                    🚪 Leave Palace
                </button>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 relative">
            
            <header class="h-24 bg-[#660000] border-b-4 border-[#D4AF37] px-10 flex items-center justify-between shadow-2xl shrink-0 z-20 font-sans">
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

            <div class="flex-1 overflow-y-auto custom-scroll p-8 md:p-12 lg:p-14">
                <form @submit.prevent="submit" class="max-w-6xl mx-auto">
                    
                    <div class="bg-gradient-to-b from-[#B91C1C] to-[#7F1D1D] rounded-[3.5rem] border-4 border-[#D4AF37] shadow-[0_40px_100px_rgba(0,0,0,0.5)] relative overflow-hidden">
                        <div class="absolute inset-0 opacity-[0.03] pointer-events-none flex items-center justify-center text-[25rem] rotate-12">💮</div>

                        <div class="p-10 md:p-14 lg:p-16 relative z-10 space-y-4">
                            
                            <div class="space-y-8">
                                <h3 class="text-[9px] font-black uppercase tracking-[0.5em] text-[#D4AF37] mb-8 ml-2 flex items-center gap-4">
                                    <span class="w-2 h-2 rounded-full bg-[#D4AF37] animate-pulse"></span>
                                    {{ translations[currentLang].config_title }}
                                </h3>
                                <div class="grid grid-cols-2 gap-12 px-6 font-sans">
                                    <div class="space-y-3">
                                        <label class="text-[8px] font-black uppercase tracking-widest opacity-40 ml-4 block">{{ translations[currentLang].labels.prefix }}</label>
                                        <input v-model="form.prefix" class="lunar-input" placeholder="LUNAR-">
                                    </div>
                                    <div class="space-y-3">
                                        <label class="text-[8px] font-black uppercase tracking-widest opacity-40 ml-4 block">{{ translations[currentLang].labels.expiry }}</label>
                                        <input v-model="form.expires_at" type="date" class="lunar-input">
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-8 pt-12"> 
                                <h3 class="text-[9px] font-black uppercase tracking-[0.5em] text-[#D4AF37] mb-8 ml-2 flex items-center gap-4">
                                    <span class="w-2 h-2 rounded-full bg-[#D4AF37] animate-pulse"></span>
                                    {{ translations[currentLang].reward_title }}
                                </h3>
                                
                                <div class="bg-[#660000]/30 border-2 border-[#D4AF37]/30 rounded-[3rem] overflow-hidden shadow-2xl backdrop-blur-sm font-sans">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="text-[9px] font-black uppercase tracking-[0.4em] text-[#D4AF37] bg-[#5E0A0A]/80 border-b border-[#D4AF37]/30">
                                                <th class="py-6 pl-12 w-28">{{ translations[currentLang].labels.th_img }}</th>
                                                <th class="py-6 px-4 w-44">{{ translations[currentLang].labels.th_type }}</th>
                                                <th class="py-6 px-4">{{ translations[currentLang].labels.th_val }}</th>
                                                <th class="py-6 px-4 w-28 text-center">{{ translations[currentLang].labels.th_qty }}</th>
                                                <th class="py-6 pr-12 w-16 text-right">{{ translations[currentLang].labels.th_act }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-[11px] font-black uppercase tracking-wider">
                                            <tr v-for="(r, i) in form.rewards" :key="i" class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-all group">
                                                <td class="py-5 pl-12">
                                                    <label :for="'img-'+i" class="w-16 h-16 bg-[#4A0000]/80 border border-[#D4AF37]/30 rounded-2xl flex items-center justify-center overflow-hidden cursor-pointer hover:border-[#D4AF37] transition-all">
                                                        <img v-if="r.preview" :src="r.preview" class="w-full h-full object-cover">
                                                        <span v-else class="text-xl opacity-20">📷</span>
                                                        <input :id="'img-'+i" type="file" @change="handleImg(i, $event)" class="hidden">
                                                    </label>
                                                </td>
                                                <td class="py-5 px-4">
                                                    <select v-model="r.type" class="lunar-select-refined">
                                                        <option value="money">{{ translations[currentLang].types.money }}</option>
                                                        <option value="item">{{ translations[currentLang].types.item }}</option>
                                                    </select>
                                                </td>
                                                <td class="py-5 px-4">
                                                    <input v-model="r.value" :type="r.type === 'money' ? 'number' : 'text'" class="lunar-input-refined" placeholder="...">
                                                </td>
                                                <td class="py-5 px-4">
                                                    <input v-model="r.quantity" type="number" class="lunar-input-refined text-center">
                                                </td>
                                                <td class="py-5 pr-12 text-right">
                                                    <button type="button" @click="removeRow(i)" class="text-lg opacity-20 hover:opacity-100 hover:scale-125 transition-all text-[#D4AF37] font-sans">✕</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="p-6 bg-[#5E0A0A]/20 border-t border-[#D4AF37]/10 flex justify-center">
                                        <button type="button" @click="addRow" class="px-8 py-3 border border-[#D4AF37]/40 rounded-full text-[9px] font-black tracking-[0.4em] text-[#F9E498]/60 hover:text-[#D4AF37] hover:border-[#D4AF37] hover:bg-[#D4AF37]/5 transition-all uppercase">
                                            {{ translations[currentLang].labels.add }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col items-center pt-8 pb-6 space-y-6 uppercase font-sans">
                                <button :disabled="form.processing" class="w-full max-w-xl py-6 bg-gradient-to-r from-[#D4AF37] via-[#F9E498] to-[#D4AF37] text-[#4A0000] font-black text-[11px] tracking-[0.6em] rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.4)] hover:scale-[1.02] transition-all disabled:opacity-50">
                                    {{ translations[currentLang].labels.submit }}
                                </button>
                                <p class="text-[8px] font-black tracking-[0.3em] opacity-30">{{ currentLang === 'id' ? 'SEGEL KERAJAAN BERLAKU SELAMANYA' : 'IMPERIAL SEALS ARE FINAL' }}</p>
                            </div>

                        </div>
                    </div>
                </form>

                <div class="py-16 text-center opacity-[0.05] text-[10rem] pointer-events-none select-none">☁️☁️☁️</div>
            </div>
        </main>
    </div>
</template>

<style scoped>
.lunar-nav {
    @apply flex items-center px-6 py-4 text-[11px] font-black uppercase tracking-[0.3em] text-[#F9E498]/60 rounded-xl transition-all duration-300;
}
.lunar-nav.active { @apply bg-gradient-to-r from-[#D4AF37] to-[#AA8A2E] text-[#4A0000] shadow-xl font-black; }

.lunar-input {
    @apply w-full bg-[#4A0000] border border-[#D4AF37]/30 rounded-[1.5rem] py-4 px-8 text-sm text-[#F9E498] font-black outline-none focus:border-[#D4AF37] focus:shadow-[0_0_15px_rgba(212,175,55,0.1)] transition-all;
}
.lunar-input-refined {
    @apply w-full bg-[#4A0000]/40 border border-[#D4AF37]/20 rounded-xl py-3 px-5 text-[11px] text-[#F9E498] font-black outline-none focus:border-[#D4AF37] focus:bg-[#4A0000]/80 transition-all;
}
.lunar-select-refined {
    @apply w-full bg-[#4A0000]/40 border border-[#D4AF37]/20 rounded-xl py-3 px-3 text-[9px] font-black text-[#F9E498] uppercase outline-none focus:border-[#D4AF37] focus:bg-[#4A0000]/80 transition-all;
}

/* --- TAMBAHAN UNTUK MENGHAPUS TANDA PANAH INPUT NUMBER --- */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type=number] {
    -moz-appearance: textfield;
}
/* --------------------------------------------------------- */

.custom-scroll::-webkit-scrollbar { width: 6px; }
.custom-scroll::-webkit-scrollbar-track { background: #4A0000; }
.custom-scroll::-webkit-scrollbar-thumb { background: #D4AF37; border-radius: 20px; }

:global(body) { 
    overflow: hidden; 
    background-color: #4A0000;
    margin: 0;
}
* { font-style: normal !important; }
</style>