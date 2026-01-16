<template>
    <AdminLayout title="Pengaturan Profil">
        <div class="max-w-4xl mx-auto space-y-6">
            
            <div class="p-6 bg-white shadow-sm border border-gray-200 rounded-2xl">
                <UpdateProfileInformationForm 
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                />
            </div>

            <div class="p-6 bg-white shadow-sm border border-gray-200 rounded-2xl">
                <UpdatePasswordForm />
            </div>

            <div class="p-6 bg-white shadow-sm border border-red-100 rounded-2xl">
                <DeleteUserForm />
            </div>
            
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});
</script>