<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { format } from 'date-fns';

const props = defineProps({
    upcomingAppointments: Array,
    pastAppointments: Array,
    stats: Object,
    enquiriesData: Object,
    role: String,
});

const statusColor = computed(() => ({
    pending: 'bg-yellow-100 text-yellow-800',
    confirmed: 'bg-green-100 text-green-800',
    cancelled: 'bg-red-100 text-red-800',
    completed: 'bg-blue-100 text-blue-800',
}));

const showEnquiries = computed(() => {
    return props.role === 'admin' || props.role === 'mentor';
});

const formatDate = (date) => {
    return format(new Date(date), 'PPpp');
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-3xl font-bold text-indigo-600">{{ stats.total }}</div>
                        <div class="text-sm text-gray-600">Total Appointments</div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-3xl font-bold text-yellow-500">{{ stats.upcoming }}</div>
                        <div class="text-sm text-gray-600">Upcoming Appointments</div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-3xl font-bold text-green-500">{{ stats.completed }}</div>
                        <div class="text-sm text-gray-600">Completed Appointments</div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-3xl font-bold text-red-500">{{ stats.cancelled }}</div>
                        <div class="text-sm text-gray-600">Cancelled Appointments</div>
                    </div>
                </div>

                <!-- Activity Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Recent Activity -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                        <div class="space-y-4">
                            <!-- Upcoming Appointments Preview -->
                            <div v-if="upcomingAppointments.length > 0">
                                <h4 class="font-medium text-gray-700 mb-2">Upcoming Appointments</h4>
                                <div v-for="appointment in upcomingAppointments.slice(0, 3)" :key="appointment.id" 
                                    class="border-b border-gray-200 last:border-b-0 py-2">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="font-medium text-gray-900">{{ appointment.title }}</div>
                                            <div class="text-sm text-gray-600">
                                                {{ formatDate(appointment.appointment_date) }}
                                            </div>
                                        </div>
                                        <Link :href="route('appointments.show', appointment.id)"
                                            class="text-sm text-indigo-600 hover:text-indigo-800">
                                            View
                                        </Link>
                                    </div>
                                </div>
                            </div>

                            <!-- Enquiries Section (Only for admin and mentors) -->
                            <div v-if="showEnquiries" class="mt-6">
                                <h4 class="font-medium text-gray-700 mb-2">Recent Enquiries</h4>
                                <div class="grid grid-cols-2 gap-2 mb-4">
                                    <div class="bg-gray-50 p-2 rounded">
                                        <div class="text-lg font-semibold">{{ enquiriesData.stats.pending }}</div>
                                        <div class="text-xs text-gray-600">Pending</div>
                                    </div>
                                    <div class="bg-gray-50 p-2 rounded">
                                        <div class="text-lg font-semibold">{{ enquiriesData.stats.assigned }}</div>
                                        <div class="text-xs text-gray-600">Assigned</div>
                                    </div>
                                </div>
                                <div v-for="enquiry in enquiriesData.recent" :key="enquiry.id" 
                                    class="border-b border-gray-200 last:border-b-0 py-2">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="font-medium text-gray-900">{{ enquiry.subject }}</div>
                                            <div class="text-sm text-gray-600">{{ enquiry.name }}</div>
                                            <div class="text-xs text-gray-500">Status: {{ enquiry.status }}</div>
                                        </div>
                                        <Link :href="route('enquiries.show', enquiry.id)"
                                            class="text-sm text-indigo-600 hover:text-indigo-800">
                                            View
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* FullCalendar styles are now imported in the script section */
</style>
