<script setup>
import { ref, watch, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const show = ref(false);
const message = ref('');

// Pantau setiap kali ada perubahan pada flash message dari Laravel
watch(() => page.props.flash?.success, (newMsg) => {
    if (newMsg) {
        message.value = newMsg;
        show.value = true;
        
        // Sembunyikan otomatis setelah 4 detik
        setTimeout(() => {
            show.value = false;
        }, 4000);
    }
}, { immediate: true });
</script>

<template>
    <div class="fixed top-5 right-5 z-[100] pointer-events-none">
        <Transition
            enter-active-class="transform ease-out duration-300 transition"
            enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="show" class="max-w-md w-full bg-white shadow-2xl rounded-2xl border-l-8 border-yellow-500 pointer-events-auto overflow-hidden">
                <div class="p-4 flex items-center gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-xl">
                        🧧
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-black text-gray-900 uppercase tracking-tight">Notifikasi Hoki</p>
                        <p class="text-xs text-gray-500 font-medium">{{ message }}</p>
                    </div>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                        ✕
                    </button>
                </div>
                <div class="h-1 bg-yellow-500/20 w-full">
                    <div class="h-full bg-yellow-500 animate-progress"></div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
@keyframes progress {
    from { width: 100%; }
    to { width: 0%; }
}
.animate-progress {
    animation: progress 4s linear forwards;
}
</style>