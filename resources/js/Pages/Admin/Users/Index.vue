<script setup>
import { ref, watch } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
});

const searchQuery = ref('');
const showCreateModal = ref(false);
const showDeleteModal = ref(false);
const userToDelete = ref(null);

const form = useForm({
    name: '',
    email: '',
    password: '',
    role: 'user',
});

const roleForm = useForm({
    role: '',
});

const handleSubmit = () => {
    form.post(route('admin.users.store'), {
        onSuccess: () => {
            form.reset();
            showCreateModal.value = false;
        },
    });
};

const confirmUserDeletion = (user) => {
    userToDelete.value = user;
    showDeleteModal.value = true;
};

const deleteUser = () => {
    if (userToDelete.value) {
        useForm().delete(route('admin.users.destroy', userToDelete.value.id), {
            onSuccess: () => {
                showDeleteModal.value = false;
                userToDelete.value = null;
            },
        });
    }
};

const updateRole = (user, newRole) => {
    roleForm.role = newRole;
    roleForm.patch(route('admin.users.update-role', user.id));
};
</script>

<template>
    <Head title="User Management" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Management</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Header Actions -->
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center">
                                <TextInput
                                    v-model="searchQuery"
                                    type="text"
                                    class="w-64"
                                    placeholder="Search users..."
                                />
                            </div>
                            <PrimaryButton @click="showCreateModal = true">
                                Create New User
                            </PrimaryButton>
                        </div>

                        <!-- Users Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="user in props.users.data" :key="user.id">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <select
                                                :value="user.role"
                                                @change="updateRole(user, $event.target.value)"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            >
                                                <option value="user">User</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <DangerButton
                                                @click="confirmUserDeletion(user)"
                                                class="ml-2"
                                            >
                                                Delete
                                            </DangerButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create User Modal -->
        <Modal :show="showCreateModal" @close="showCreateModal = false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Create New User</h2>
                <form @submit.prevent="handleSubmit" class="mt-6">
                    <div class="mt-6">
                        <InputLabel for="name" value="Name" />
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.email" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <InputLabel for="password" value="Password" />
                        <TextInput
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <InputLabel for="role" value="Role" />
                        <select
                            id="role"
                            v-model="form.role"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        >
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        <InputError :message="form.errors.role" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Create User
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>

        <!-- Delete User Modal -->
        <Modal :show="showDeleteModal" @close="showDeleteModal = false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Delete User</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Are you sure you want to delete this user? This action cannot be undone.
                </p>

                <div class="mt-6 flex justify-end">
                    <PrimaryButton class="mr-3" @click="showDeleteModal = false">
                        Cancel
                    </PrimaryButton>
                    <DangerButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteUser">
                        Delete User
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template> 