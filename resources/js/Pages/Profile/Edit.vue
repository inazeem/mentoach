<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UserManagementForm from './Partials/UserManagementForm.vue';
import ConfigSettingsForm from './Partials/ConfigSettingsForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const activeTab = ref('profile');
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Profile Settings
                </h2>
                <Link :href="route('dashboard')"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Back to Dashboard
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-6">
                    <!-- Navigation Sidebar -->
                    <div class="md:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-14 w-14 rounded-full bg-orange-100">
                                            <span class="text-xl font-medium leading-none text-orange-700">
                                                {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $page.props.auth.user.name }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            {{ $page.props.auth.user.email }}
                                        </p>
                                    </div>
                                </div>

                                <nav class="mt-6 space-y-2">
                                    <button @click="activeTab = 'profile'"
                                        :class="[
                                            'w-full flex items-center px-4 py-2 text-sm font-medium rounded-md',
                                            activeTab === 'profile'
                                                ? 'bg-orange-50 text-orange-700'
                                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                                        ]">
                                        <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profile Information
                                    </button>

                                    <button @click="activeTab = 'password'"
                                        :class="[
                                            'w-full flex items-center px-4 py-2 text-sm font-medium rounded-md',
                                            activeTab === 'password'
                                                ? 'bg-orange-50 text-orange-700'
                                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                                        ]">
                                        <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                        Update Password
                                    </button>

                                    <button @click="activeTab = 'delete'"
                                        :class="[
                                            'w-full flex items-center px-4 py-2 text-sm font-medium rounded-md',
                                            activeTab === 'delete'
                                                ? 'bg-red-50 text-red-700'
                                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                                        ]">
                                        <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Account
                                    </button>

                                    <!-- Auth Navigation -->
                                    <div class="mt-6 border-t border-gray-200 pt-4">
                                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Authentication
                                        </h3>
                                        <div class="mt-3 space-y-2">
                                            <template v-if="$page.props.auth.user">
                                                <Link
                                                    :href="route('logout')"
                                                    method="post"
                                                    as="button"
                                                    class="w-full flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md"
                                                >
                                                    <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                    </svg>
                                                    Logout
                                                </Link>
                                            </template>
                                            <template v-else>
                                                <Link
                                                    :href="route('login')"
                                                    class="w-full flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md"
                                                >
                                                    <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                                    </svg>
                                                    Login
                                                </Link>
                                                <Link
                                                    :href="route('register')"
                                                    class="w-full flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md"
                                                >
                                                    <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                    </svg>
                                                    Register
                                                </Link>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Admin Section -->
                                    <template v-if="$page.props.auth.user && $page.props.auth.user.role === 'admin'">
                                        <div class="mt-6 border-t border-gray-200 pt-4">
                                            <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Admin Settings
                                            </h3>
                                        </div>

                                        <button @click="activeTab = 'users'"
                                            :class="[
                                                'w-full flex items-center px-4 py-2 text-sm font-medium rounded-md',
                                                activeTab === 'users'
                                                    ? 'bg-orange-50 text-orange-700'
                                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                                            ]">
                                            <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            User Management
                                        </button>

                                        <button @click="activeTab = 'config'"
                                            :class="[
                                                'w-full flex items-center px-4 py-2 text-sm font-medium rounded-md',
                                                activeTab === 'config'
                                                    ? 'bg-orange-50 text-orange-700'
                                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                                            ]">
                                            <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Configuration Settings
                                        </button>
                                    </template>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Area -->
                    <div class="md:col-span-4 space-y-6">
                        <Transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="opacity-0 translate-y-1"
                            enter-to-class="opacity-100 translate-y-0"
                            leave-active-class="transition ease-in duration-150"
                            leave-from-class="opacity-100 translate-y-0"
                            leave-to-class="opacity-0 translate-y-1"
                        >
                            <div class="transition-wrapper">
                                <div v-if="activeTab === 'profile'" class="bg-white rounded-lg shadow-sm overflow-hidden">
                                    <UpdateProfileInformationForm
                                        :must-verify-email="mustVerifyEmail"
                                        :status="status"
                                    />
                                </div>

                                <div v-if="activeTab === 'password'" class="bg-white rounded-lg shadow-sm overflow-hidden">
                                    <UpdatePasswordForm />
                                </div>

                                <div v-if="activeTab === 'delete'" class="bg-white rounded-lg shadow-sm overflow-hidden">
                                    <DeleteUserForm />
                                </div>

                                <div v-if="activeTab === 'users'" class="bg-white rounded-lg shadow-sm overflow-hidden">
                                    <UserManagementForm />
                                </div>

                                <div v-if="activeTab === 'config'" class="bg-white rounded-lg shadow-sm overflow-hidden">
                                    <ConfigSettingsForm />
                                </div>
                            </div>
                        </Transition>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
