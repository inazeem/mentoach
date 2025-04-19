<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const users = ref([]);
const searchQuery = ref('');

const form = useForm({
    name: '',
    email: '',
    password: '',
    role: 'user',
});

const getUsers = async () => {
    const response = await axios.get(route('admin.users.index'));
    users.value = response.data;
};

const createUser = () => {
    form.post(route('admin.users.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            getUsers();
        },
    });
};

const deleteUser = (userId) => {
    if (confirm('Are you sure you want to delete this user?')) {
        axios.delete(route('admin.users.destroy', userId))
            .then(() => {
                getUsers();
            });
    }
};

const updateUserRole = (userId, newRole) => {
    axios.patch(route('admin.users.update-role', userId), { role: newRole })
        .then(() => {
            getUsers();
        });
};

onMounted(() => {
    getUsers();
});
</script>

<template>
    <section class="p-4 sm:p-8">
        <header>
            <h2 class="text-lg font-medium text-gray-900">User Management</h2>
            <p class="mt-1 text-sm text-gray-600">
                Manage users, their roles, and permissions.
            </p>
        </header>

        <form @submit.prevent="createUser" class="mt-6 space-y-6">
            <div>
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

            <div>
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

            <div>
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

            <div>
                <InputLabel for="role" value="Role" />
                <select
                    id="role"
                    v-model="form.role"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500"
                >
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <InputError :message="form.errors.role" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Create User</PrimaryButton>
            </div>
        </form>

        <div class="mt-8">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Users List</h3>
                <TextInput
                    v-model="searchQuery"
                    type="search"
                    placeholder="Search users..."
                    class="w-64"
                />
            </div>

            <div class="mt-4 overflow-x-auto">
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
                        <tr v-for="user in users.filter(u => 
                            u.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
                            u.email.toLowerCase().includes(searchQuery.toLowerCase())
                        )" :key="user.id">
                            <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <select
                                    v-model="user.role"
                                    @change="updateUserRole(user.id, $event.target.value)"
                                    class="border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                >
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button
                                    @click="deleteUser(user.id)"
                                    class="text-red-600 hover:text-red-900"
                                >Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</template> 