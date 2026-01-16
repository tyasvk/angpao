<template>
    <section>
        <header>
            <h2 class="text-lg font-bold text-gray-900">Perbarui Kata Sandi</h2>
            <p class="mt-1 text-sm text-gray-600">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.</p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-4 max-w-xl">
            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Kata Sandi Saat Ini</label>
                <input v-model="form.current_password" type="password" class="w-full border-gray-300 rounded-xl focus:ring-red-500 focus:border-red-500" />
                <p v-if="form.errors.current_password" class="text-red-500 text-xs mt-1">{{ form.errors.current_password }}</p>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Kata Sandi Baru</label>
                <input v-model="form.password" type="password" class="w-full border-gray-300 rounded-xl focus:ring-red-500 focus:border-red-500" />
                <p v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</p>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Konfirmasi Kata Sandi</label>
                <input v-model="form.password_confirmation" type="password" class="w-full border-gray-300 rounded-xl focus:ring-red-500 focus:border-red-500" />
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button :disabled="form.processing" class="bg-red-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-red-700 transition">
                    Simpan Perubahan
                </button>
                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-green-600 font-bold">Tersimpan!</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>