<template>
  <AdminLayout>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500 uppercase font-bold">Total Sales</p>
        <p class="text-3xl font-extrabold mt-2">$24,500</p>
      </div>
      
      <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500 uppercase font-bold">Active Users</p>
        <p class="text-3xl font-extrabold mt-2">1,240</p>
      </div>

      <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500 uppercase font-bold">Server Latency</p>
        <p class="text-3xl font-extrabold mt-2 text-green-500">2ms</p>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
</script>