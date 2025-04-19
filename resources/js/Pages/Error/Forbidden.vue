<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    status: {
        type: Number,
        required: true,
    },
    message: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="403: Forbidden" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                403: Forbidden
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-center">
                            <h1 class="text-6xl font-bold text-red-500 mb-4">403</h1>
                            <p class="text-xl mb-4">{{ message }}</p>
                            <a href="/" class="text-blue-500 hover:text-blue-700">
                                Return to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 