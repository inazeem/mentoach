<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    appointments: Array,
});
</script>

<template>
    <Head title="Appointments" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Appointments
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium">Your Appointments</h3>
                            <Link
                                :href="route('appointments.create')"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700"
                            >
                                Book New Appointment
                            </Link>
                        </div>

                        <div v-if="appointments.length === 0" class="text-center py-8">
                            <p class="text-gray-500">No appointments found.</p>
                        </div>

                        <div v-else class="space-y-4">
                            <div
                                v-for="appointment in appointments"
                                :key="appointment.id"
                                class="border rounded-lg p-4 hover:shadow-md transition-shadow"
                            >
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-lg">{{ appointment.title }}</h4>
                                        <p class="text-gray-600">
                                            With {{ appointment.mentor.name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ new Date(appointment.appointment_date).toLocaleString() }}
                                            ({{ appointment.duration }} minutes)
                                        </p>
                                        <p class="mt-2" v-if="appointment.description">
                                            {{ appointment.description }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span
                                            :class="{
                                                'bg-yellow-100 text-yellow-800': appointment.status === 'pending',
                                                'bg-green-100 text-green-800': appointment.status === 'confirmed',
                                                'bg-red-100 text-red-800': appointment.status === 'cancelled',
                                                'bg-blue-100 text-blue-800': appointment.status === 'completed'
                                            }"
                                            class="px-2 py-1 rounded-full text-xs font-medium"
                                        >
                                            {{ appointment.status }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-4 flex justify-end space-x-2">
                                    <Link
                                        :href="route('appointments.show', appointment.id)"
                                        class="text-indigo-600 hover:text-indigo-800"
                                    >
                                        View Details
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 