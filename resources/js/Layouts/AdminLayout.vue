<template>
    <div class="flex h-screen bg-[#F9FAFB] font-sans text-gray-900">
        <Toast />

        <aside class="w-72 bg-red-800 text-white flex flex-col shadow-2xl z-20">
            <div class="p-8 border-b border-red-700/50">
                <div class="flex items-center gap-3">
                    <span class="text-4xl drop-shadow-lg">🧧</span>
                    <div>
                        <h1 class="text-xl font-black tracking-tighter leading-none">ANGPAO</h1>
                        <p class="text-[10px] text-red-300 font-bold tracking-widest uppercase mt-1">Sistem Kontrol</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <Link :href="route('admin.dashboard')" :class="[$page.component === 'Admin/Dashboard' ? 'bg-red-900 text-yellow-400 shadow-inner' : 'text-red-100 hover:bg-red-700/50']" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all font-bold group">
                    <span class="text-xl group-hover:scale-110 transition-transform">📊</span> Dashboard
                </Link>

                <Link :href="route('admin.vouchers.index')" :class="[$page.component === 'Admin/Vouchers/Index' ? 'bg-red-900 text-yellow-400 shadow-inner' : 'text-red-100 hover:bg-red-700/50']" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all font-bold group">
                    <span class="text-xl group-hover:scale-110 transition-transform">🎫</span> Kelola Voucher
                </Link>

                <Link :href="route('admin.profile.edit')" :class="[$page.component === 'Admin/Profile/Edit' ? 'bg-red-900 text-yellow-400 shadow-inner' : 'text-red-100 hover:bg-red-700/50']" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all font-bold group">
                    <span class="text-xl group-hover:scale-110 transition-transform">⚙️</span> Profil
                </Link>
            </nav>

            <div class="p-4 m-4 bg-red-900/50 rounded-3xl border border-red-700/30">
                <div class="flex items-center gap-3 px-2 mb-4">
                    <div class="w-10 h-10 rounded-2xl bg-yellow-500 flex items-center justify-center text-red-900 font-black shadow-lg uppercase">
                        {{ $page.props.auth.user.name.charAt(0) }}
                    </div>
                    <div class="overflow-hidden text-ellipsis whitespace-nowrap">
                        <p class="text-sm font-black truncate">{{ $page.props.auth.user.name }}</p>
                        <p class="text-[10px] text-red-300 font-medium">Administrator</p>
                    </div>
                </div>
                <Link :href="route('logout')" method="post" as="button" class="w-full py-3 bg-red-700 hover:bg-red-600 text-white rounded-2xl transition-all font-black text-xs uppercase tracking-widest active:scale-95">
                    🚪 Keluar
                </Link>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-10">
                <h2 class="font-black text-gray-800 text-xl uppercase tracking-tight">
                    <span class="text-gray-300 font-light mr-2">/</span> {{ title }}
                </h2>
                <Link href="/" class="px-4 py-2 border-2 border-red-100 text-red-600 rounded-xl text-xs font-black hover:bg-red-50 transition-all uppercase tracking-widest">
                    🏠 Lihat Web
                </Link>
            </header>

            <main class="flex-1 overflow-y-auto p-8 lg:p-12">
                <Transition name="page-fade" mode="out-in" appear>
                    <div :key="$page.url">
                        <slot />
                    </div>
                </Transition>
            </main>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Toast from '@/Components/Toast.vue';

defineProps({ title: String });
</script>

<style>
/* CSS Animasi Transisi */
.page-fade-enter-active, .page-fade-leave-active {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.page-fade-enter-from {
    opacity: 0;
    transform: translateY(10px);
}
.page-fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>