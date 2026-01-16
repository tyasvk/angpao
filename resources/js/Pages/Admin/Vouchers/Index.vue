<template>
  <div class="min-h-screen bg-gray-100 p-8 font-sans text-gray-900">
    <div class="max-w-5xl mx-auto">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Manajemen Voucher Angpao</h1>
        <button v-if="isEditing" @click="cancelEdit" class="text-sm text-gray-500 hover:underline">
          Batal Edit / Tambah Baru
        </button>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 mb-8">
        <h2 class="text-lg font-bold mb-4">{{ isEditing ? 'Edit Voucher: ' + form.code : 'Tambah Voucher Baru' }}</h2>
        <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kode</label>
            <input v-model="form.code" type="text" class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 uppercase">
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nominal (Rp)</label>
            <input v-model="form.amount" type="number" class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kuota</label>
            <input v-model="form.limit" type="number" class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
          </div>
          <button :disabled="form.processing" class="bg-red-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700 transition">
            {{ isEditing ? 'Simpan Perubahan' : 'Buat Voucher' }}
          </button>
        </form>
      </div>

      <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
          <thead class="bg-gray-50 border-b border-gray-200 text-xs font-bold uppercase text-gray-500">
            <tr>
              <th class="px-6 py-4">Kode</th>
              <th class="px-6 py-4">Nominal</th>
              <th class="px-6 py-4">Penggunaan</th>
              <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="voucher in vouchers" :key="voucher.id" class="hover:bg-gray-50 transition" :class="{'bg-yellow-50': isEditing && selectedId === voucher.id}">
              <td class="px-6 py-4 font-mono font-bold text-red-600 uppercase">{{ voucher.code }}</td>
              <td class="px-6 py-4 font-semibold text-gray-700">Rp {{ Number(voucher.amount).toLocaleString('id-ID') }}</td>
              <td class="px-6 py-4 text-sm">
                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1 max-w-[100px]">
                  <div class="bg-green-500 h-1.5 rounded-full" :style="{ width: (voucher.used / voucher.limit * 100) + '%' }"></div>
                </div>
                {{ voucher.used }} / {{ voucher.limit }}
              </td>
              <td class="px-6 py-4 text-right space-x-3">
                <button @click="editVoucher(voucher)" class="text-blue-600 hover:text-blue-800 font-bold text-sm">Edit</button>
                <button @click="deleteVoucher(voucher.id)" class="text-red-500 hover:text-red-700 font-bold text-sm">Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';

const props = defineProps({ vouchers: Array });

// State untuk melacak apakah sedang mengedit
const isEditing = ref(false);
const selectedId = ref(null);

const form = useForm({
  code: '',
  amount: 0,
  limit: 1,
});

// Masuk ke mode edit
const editVoucher = (voucher) => {
  isEditing.value = true;
  selectedId.value = voucher.id;
  form.code = voucher.code;
  form.amount = voucher.amount;
  form.limit = voucher.limit;
  window.scrollTo({ top: 0, behavior: 'smooth' }); // Scroll ke atas untuk edit
};

// Keluar dari mode edit
const cancelEdit = () => {
  isEditing.value = false;
  selectedId.value = null;
  form.reset();
};

const submit = () => {
  if (isEditing.value) {
    // Jalankan UPDATE
    form.put(route('admin.vouchers.update', selectedId.value), {
      onSuccess: () => cancelEdit(),
    });
  } else {
    // Jalankan STORE
    form.post(route('admin.vouchers.store'), {
      onSuccess: () => form.reset(),
    });
  }
};

const deleteVoucher = (id) => {
  if (confirm('Yakin ingin menghapus voucher ini?')) {
    router.delete(route('admin.vouchers.destroy', id));
  }
};
</script>