<script setup>
import { Link, Head } from '@inertiajs/vue3';

defineProps({
    title: String
});
</script>

<template>
    <Head :title="title + ' — Imperial Admin'" />

    <div class="h-screen w-full bg-[#4A0000] flex overflow-hidden font-sans text-[#F9E498] relative">
        
        <aside class="w-72 bg-gradient-to-b from-[#990000] to-[#4A0000] flex flex-col h-screen border-r-4 border-[#D4AF37] shadow-2xl fixed left-0 top-0 z-50 shrink-0">
            <div class="absolute inset-0 opacity-5 pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/chinese-lanterns.png')]"></div>
            
            <div class="p-8 border-b border-[#D4AF37]/30 flex flex-col items-center relative z-10">
                <div class="w-16 h-16 bg-[#D4AF37] rounded-2xl flex items-center justify-center text-4xl shadow-lg mb-4 rotate-3 border-2 border-[#F9E498]">🧧</div>
                <h2 class="text-lg font-black tracking-[0.2em] uppercase text-center leading-tight bg-clip-text text-transparent bg-gradient-to-b from-[#FFF3B0] to-[#D4AF37]">
                    Imperial Admin
                </h2>
                <p class="text-[9px] font-black text-[#F9E498] uppercase tracking-[0.3em] mt-2 opacity-80 text-center">Fortune Access</p>
            </div>
            
            <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scroll relative z-10">
                <Link :href="route('admin.dashboard')" class="lunar-nav" :class="{ 'active': $page.component === 'Admin/Dashboard' }">
                    <span>📊</span> <span class="ml-3">Ringkasan Utama</span>
                </Link>
                
                <Link :href="route('admin.angpao.index')" class="lunar-nav" :class="{ 'active': $page.component === 'Admin/Angpao/Index' }">
                    <span>📜</span> <span class="ml-3">Gudang Voucher</span>
                </Link>

                <Link :href="route('admin.angpao.create')" class="lunar-nav" :class="{ 'active': $page.component === 'Admin/Angpao/Create' }">
                    <span>👑</span> <span class="ml-3">Rilis Angpao Baru</span>
                </Link>

                <Link :href="route('admin.settings.welcome')" class="lunar-nav" :class="{ 'active': $page.component === 'Admin/Settings/Welcome' }">
                    <span>⚙️</span> <span class="ml-3">Edit Welcome</span>
                </Link>

                <Link :href="route('admin.angpao.history')" class="lunar-nav" :class="{ 'active': $page.component === 'Admin/Angpao/History' }">
                    <span>⌛</span> <span class="ml-3">Riwayat Klaim</span>
                </Link>
            </nav>

            <div class="p-6 border-t border-[#D4AF37]/30 z-10">
                <Link :href="route('logout')" method="post" as="button" class="w-full flex items-center px-6 py-4 text-[10px] font-black uppercase tracking-[0.3em] text-[#F9E498] opacity-50 hover:opacity-100 transition-all">
                    🚪 Leave Palace
                </Link>
            </div>
        </aside>

        <main class="flex-1 ml-72 flex flex-col min-w-0 relative h-screen overflow-hidden">
            <header class="h-24 bg-[#660000] border-b-4 border-[#D4AF37] px-10 flex items-center justify-between shadow-2xl shrink-0 z-40">
                <slot name="header" />
            </header>

            <div class="flex-1 overflow-y-auto custom-scroll p-10">
                <slot />
            </div>
        </main>
    </div>
</template>

<style scoped>
.lunar-nav { @apply flex items-center px-6 py-4 text-[11px] font-black uppercase tracking-[0.3em] text-[#F9E498]/60 rounded-xl transition-all duration-300; }
.lunar-nav:hover { @apply bg-[#D4AF37]/10 text-[#F9E498]; }
.lunar-nav.active { @apply bg-gradient-to-r from-[#D4AF37] to-[#AA8A2E] text-[#4A0000] shadow-xl font-black; }
.custom-scroll::-webkit-scrollbar { width: 6px; }
.custom-scroll::-webkit-scrollbar-thumb { background: #D4AF37; border-radius: 10px; }
</style>