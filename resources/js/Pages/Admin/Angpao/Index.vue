<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';

const props = defineProps({
    angpaos: Object, // Objek paginasi
    filters: Object
});

// Logic Search & Filter
const search = ref(props.filters?.search || '');
const statusFilter = ref(props.filters?.status || '');
const selectedIds = ref([]);

watch([search, statusFilter], ([newSearch, newStatus]) => {
    router.get(route('admin.angpao.index'), { 
        search: newSearch, 
        status: newStatus 
    }, { preserveState: true, replace: true });
});

// Logic Select All
const selectAll = computed({
    get: () => (props.angpaos?.data?.length > 0) && (selectedIds.value.length === props.angpaos?.data?.length),
    set: (val) => selectedIds.value = val ? props.angpaos?.data?.map(a => a.id) : []
});

// Logic Hapus
const deleteSingle = (id) => {
    if (confirm('Hapus voucher ini?')) {
        router.delete(route('admin.angpao.destroy', id));
    }
};

const deleteBatch = () => {
    if (confirm(`Hapus ${selectedIds.value.length} voucher terpilih?`)) {
        router.post(route('admin.angpao.destroyBatch'), { 
            _method: 'DELETE', 
            ids: selectedIds.value 
        }, {
            onSuccess: () => selectedIds.value = []
        });
    }
};
</script>

<template>
    <AdminLayout title="Gudang Voucher">
        
        <template #header>
            <div class="flex-1">
                <h1 class="text-2xl font-black tracking-widest uppercase bg-clip-text text-transparent bg-gradient-to-b from-[#FFF3B0] to-[#D4AF37]">
                    Gudang Voucher
                </h1>
                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-[#F9E498] opacity-60">
                    Manajemen Segel Rahasia Kaisar
                </p>
            </div>

            <div class="flex items-center gap-4">
                <button v-if="selectedIds.length > 0" @click="deleteBatch" 
                        class="px-5 py-2 bg-[#F9E498] text-[#4A0000] text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-white transition-all">
                    Hapus Terpilih ({{ selectedIds.length }})
                </button>

                <select v-model="statusFilter" class="lunar-select">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="claimed">Terklaim</option>
                </select>

                <div class="relative">
                    <input v-model="search" type="text" placeholder="CARI KODE..." class="lunar-search-input">
                    <span class="absolute left-3 top-2.5 opacity-30 text-xs">🔍</span>
                </div>
            </div>
        </template>

        <div class="bg-[#660000]/40 border-4 border-[#D4AF37] rounded-[3rem] p-10 shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 opacity-[0.03] pointer-events-none flex items-center justify-center text-[15rem]">💮</div>
            
            <div class="relative z-10">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[9px] font-black uppercase tracking-[0.3em] text-[#D4AF37]/60 border-b border-[#D4AF37]/20">
                            <th class="py-4 px-4 w-10">
                                <input type="checkbox" v-model="selectAll" class="rounded border-[#D4AF37] bg-[#4A0000] text-[#D4AF37] focus:ring-[#D4AF37]">
                            </th>
                            <th class="py-4">Kode Voucher</th>
                            <th class="py-4 text-center">Status</th>
                            <th class="py-4 text-right px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs font-black uppercase tracking-widest">
                        <tr v-for="a in angpaos?.data" :key="a.id" class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-all">
                            <td class="py-4 px-4">
                                <input type="checkbox" :value="a.id" v-model="selectedIds" class="rounded border-[#D4AF37] bg-[#4A0000] text-[#D4AF37] focus:ring-[#D4AF37]">
                            </td>
                            <td class="py-4">
                                <span class="bg-[#4A0000] px-4 py-1.5 rounded-xl border border-[#D4AF37] text-[11px] font-mono tracking-widest text-[#F9E498]">
                                    {{ a.code }}
                                </span>
                            </td>
                            <td class="py-4 text-center">
                                <span :class="a.status === 'active' ? 'bg-[#D4AF37] text-[#4A0000]' : 'opacity-40'" class="px-4 py-1 rounded-full text-[8px] border border-[#F9E498]/30 transition-all uppercase">
                                    {{ a.status }}
                                </span>
                            </td>
                            <td class="py-4 text-right px-4">
                                <button @click="deleteSingle(a.id)" class="text-xl hover:scale-125 transition-transform opacity-50 hover:opacity-100">🗑️</button>
                            </td>
                        </tr>
                        <tr v-if="!angpaos?.data?.length">
                            <td colspan="4" class="py-20 text-center opacity-20 text-[10px] tracking-widest">TIDAK ADA DATA VOUCHER</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="angpaos?.links" class="mt-10 pt-10 border-t-2 border-[#D4AF37]/20 flex justify-center gap-2 relative z-10">
                <Link v-for="link in angpaos.links" :key="link.label" :href="link.url || '#'" v-html="link.label" 
                      class="px-4 py-2 rounded-xl text-[9px] font-black uppercase transition-all"
                      :class="[
                          link.active ? 'bg-[#D4AF37] text-[#4A0000] shadow-lg scale-105' : 'bg-[#4A0000] text-[#D4AF37] border border-[#D4AF37]/30 hover:bg-[#D4AF37]/10',
                          !link.url ? 'opacity-20 cursor-not-allowed' : ''
                      ]"
                />
            </div>
        </div>

        <div class="py-20 text-center opacity-10 text-9xl pointer-events-none select-none">☁️☁️☁️</div>
    </AdminLayout>
</template>

<style scoped>
.lunar-select {
    @apply bg-[#4A0000] border-2 border-[#D4AF37] rounded-xl px-4 py-2 text-[9px] font-black uppercase text-[#F9E498] outline-none transition-all focus:border-[#F9E498];
}

.lunar-search-input {
    @apply pl-10 pr-4 py-2 bg-[#4A0000] border-2 border-[#D4AF37] rounded-xl text-[11px] text-[#F9E498] outline-none w-64 font-black transition-all focus:border-[#F9E498];
}

* { font-style: normal !important; }
</style>