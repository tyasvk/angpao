<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    prefix: 'LUNAR-',
    expires_at: '',
    rewards: [{ type: 'money', value: '', quantity: 1, image: null, preview: null }]
});

const addRow = () => form.rewards.push({ type: 'money', value: '', quantity: 1, image: null, preview: null });
const removeRow = (i) => form.rewards.length > 1 && form.rewards.splice(i, 1);
const handleImg = (i, e) => {
    const file = e.target.files[0];
    if (file) {
        form.rewards[i].image = file;
        form.rewards[i].preview = URL.createObjectURL(file);
    }
};

const submit = () => form.post(route('admin.angpao.store'), { forceFormData: true, onSuccess: () => form.reset() });
</script>

<template>
    <AdminLayout title="Issue Fortune">
        <template #header>
            <div>
                <h1 class="text-2xl font-black tracking-widest uppercase bg-clip-text text-transparent bg-gradient-to-b from-[#FFF3B0] to-[#D4AF37]">
                    Rilis Angpao
                </h1>
                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-[#F9E498] opacity-60">Penerbitan Segel Keberuntungan</p>
            </div>
        </template>

        <form @submit.prevent="submit" class="max-w-5xl mx-auto space-y-8">
            <div class="bg-gradient-to-b from-[#B91C1C] to-[#7F1D1D] rounded-[3.5rem] border-4 border-[#D4AF37] p-10 shadow-2xl">
                <div class="grid grid-cols-2 gap-8 mb-10">
                    <div class="space-y-2">
                        <label class="text-[8px] font-black uppercase tracking-widest opacity-40 ml-4">Prefix Kode</label>
                        <input v-model="form.prefix" class="lunar-input" placeholder="LUNAR-">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[8px] font-black uppercase tracking-widest opacity-40 ml-4">Masa Berlaku</label>
                        <input v-model="form.expires_at" type="date" class="lunar-input">
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-[9px] font-black uppercase tracking-[0.5em] text-[#D4AF37] mb-4">Manifes Hadiah</h3>
                    <div v-for="(r, i) in form.rewards" :key="i" class="flex items-center gap-4 bg-[#4A0000]/40 p-4 rounded-2xl border border-[#D4AF37]/20 group">
                        <label class="w-14 h-14 bg-[#4A0000] border border-[#D4AF37]/30 rounded-xl flex items-center justify-center overflow-hidden cursor-pointer">
                            <img v-if="r.preview" :src="r.preview" class="w-full h-full object-cover">
                            <span v-else class="text-xl opacity-20">📷</span>
                            <input type="file" @change="handleImg(i, $event)" class="hidden">
                        </label>
                        <select v-model="r.type" class="bg-transparent border-2 border-[#D4AF37]/30 rounded-xl px-3 py-2 text-[10px] font-black text-[#F9E498] uppercase outline-none">
                            <option value="money">Tunai</option>
                            <option value="item">Barang</option>
                        </select>
                        <input v-model="r.value" :type="r.type === 'money' ? 'number' : 'text'" class="flex-1 bg-transparent border-2 border-[#D4AF37]/30 rounded-xl px-4 py-2 text-xs font-black text-[#F9E498]" placeholder="Nominal / Nama Hadiah">
                        <input v-model="r.quantity" type="number" class="w-20 bg-transparent border-2 border-[#D4AF37]/30 rounded-xl px-2 py-2 text-center text-xs font-black text-[#F9E498]">
                        <button type="button" @click="removeRow(i)" class="text-[#D4AF37] opacity-40 hover:opacity-100 transition-opacity">✕</button>
                    </div>
                    <button type="button" @click="addRow" class="w-full py-3 border-2 border-dashed border-[#D4AF37]/30 rounded-2xl text-[9px] font-black tracking-widest opacity-50 hover:opacity-100 transition-opacity uppercase">
                        Tambah Baris Hadiah +
                    </button>
                </div>

                <button :disabled="form.processing" class="w-full mt-10 py-5 bg-gradient-to-r from-[#D4AF37] via-[#F9E498] to-[#D4AF37] text-[#4A0000] font-black text-[11px] tracking-[0.5em] rounded-3xl shadow-xl hover:scale-[1.02] transition-all uppercase">
                    Segel & Terbitkan Angpao 🧧
                </button>
            </div>
        </form>
    </AdminLayout>
</template>

<style scoped>
.lunar-input { @apply w-full bg-[#4A0000] border-2 border-[#D4AF37]/30 rounded-2xl py-3 px-6 text-sm text-[#F9E498] font-black outline-none focus:border-[#D4AF37] transition-all; }
</style>