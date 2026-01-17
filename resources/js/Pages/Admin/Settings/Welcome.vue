<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ settings: Object });

const form = useForm({
    welcome_title: props.settings?.welcome_title || 'Imperial Fortune',
    welcome_subtitle: props.settings?.welcome_subtitle || 'Fortune Access • Imlek 2026',
    show_prize_pool: props.settings?.show_prize_pool === '1' || props.settings?.show_prize_pool === true,
    show_my_gifts: props.settings?.show_my_gifts === '1' || props.settings?.show_my_gifts === true,
});

const submit = () => form.post(route('admin.settings.welcome.update'), { preserveScroll: true });
</script>

<template>
    <AdminLayout title="Edit Welcome">
        <template #header>
            <div>
                <h1 class="text-2xl font-black tracking-widest uppercase bg-clip-text text-transparent bg-gradient-to-b from-[#FFF3B0] to-[#D4AF37]">
                    Edit Welcome
                </h1>
                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-[#F9E498] opacity-60">Konfigurasi Gerbang Istana</p>
            </div>
        </template>

        <form @submit.prevent="submit" class="max-w-4xl space-y-8">
            <div class="bg-[#660000]/40 border-4 border-[#D4AF37] rounded-[3rem] p-10 shadow-2xl space-y-8">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[9px] font-black uppercase tracking-widest opacity-40 ml-4">Judul Utama</label>
                        <input v-model="form.welcome_title" class="lunar-input" type="text">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[9px] font-black uppercase tracking-widest opacity-40 ml-4">Sub Judul</label>
                        <input v-model="form.welcome_subtitle" class="lunar-input" type="text">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="flex items-center justify-between bg-[#4A0000]/60 p-6 rounded-2xl border border-[#D4AF37]/20 cursor-pointer">
                        <span class="text-[10px] font-black uppercase tracking-widest">Tampilkan Prize Pool</span>
                        <input type="checkbox" v-model="form.show_prize_pool" class="w-6 h-6 accent-[#D4AF37]">
                    </label>
                    <label class="flex items-center justify-between bg-[#4A0000]/60 p-6 rounded-2xl border border-[#D4AF37]/20 cursor-pointer">
                        <span class="text-[10px] font-black uppercase tracking-widest">Tampilkan Riwayat Saya</span>
                        <input type="checkbox" v-model="form.show_my_gifts" class="w-6 h-6 accent-[#D4AF37]">
                    </label>
                </div>
            </div>

            <button :disabled="form.processing" class="w-full py-6 bg-gradient-to-r from-[#D4AF37] via-[#F9E498] to-[#D4AF37] text-[#4A0000] font-black text-[11px] tracking-[0.6em] rounded-[2rem] shadow-xl hover:scale-[1.01] transition-all uppercase">
                Simpan Konfigurasi 🧧
            </button>
        </form>
    </AdminLayout>
</template>

<style scoped>
.lunar-input { @apply w-full bg-[#4A0000] border-2 border-[#D4AF37]/40 rounded-2xl py-4 px-6 text-xs font-black tracking-widest text-[#F9E498] outline-none focus:border-[#D4AF37] transition-all uppercase shadow-inner; }
</style>