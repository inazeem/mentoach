<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { format } from 'date-fns';

const props = defineProps({
    appointments: Array,
});

const formatDate = (date) => {
    return format(new Date(date), 'PPpp');
};

const getStatusColor = (status) => {
    const colors = {
        pending: 'bg-yellow-100 text-yellow-800 border-yellow-200',
        confirmed: 'bg-green-100 text-green-800 border-green-200',
        cancelled: 'bg-red-100 text-red-800 border-red-200',
        completed: 'bg-blue-100 text-blue-800 border-blue-200'
    };
    return colors[status] || 'bg-gray-100 text-gray-800 border-gray-200';
};
</script>

<template>
    <Head title="Appointments" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Your Appointments
                </h2>
                <div class="text-sm text-gray-500">
                    {{ new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Quick Actions -->
                <div class="mb-8 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <select class="appearance-none bg-white border border-gray-300 rounded-lg pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="all">All Appointments</option>
                                <option value="upcoming">Upcoming</option>
                                <option value="past">Past</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <Link
                        :href="route('appointments.create')"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Book New Appointment
                    </Link>
                </div>

                <!-- Appointments Grid -->
                <div class="grid gap-6">
                    <div v-if="appointments.length === 0" 
                        class="bg-white rounded-2xl shadow-sm p-12 text-center">
                        <div class="mx-auto h-24 w-24 flex items-center justify-center rounded-full bg-orange-100 mb-8">
                            <svg class="h-12 w-12 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Appointments Found</h3>
                        <p class="text-gray-500 mb-8">You haven't booked any appointments yet. Start by booking your first session.</p>
                        <Link
                            :href="route('appointments.create')"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200"
                        >
                            Book Your First Session
                        </Link>
                    </div>

                    <div v-else
                        v-for="appointment in appointments"
                        :key="appointment.id"
                        class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden"
                    >
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4">
                                    <div class="h-12 w-12 flex-shrink-0">
                                        <div class="h-full w-full rounded-full bg-orange-100 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900">{{ appointment.title }}</h3>
                                        <p class="text-gray-600 mt-1">
                                            with <span class="font-medium text-navy-800">{{ appointment.mentor.name }}</span>
                                        </p>
                                        <div class="mt-2 flex items-center space-x-4">
                                            <div class="flex items-center text-gray-500">
                                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ formatDate(appointment.appointment_date) }}
                                            </div>
                                            <div class="flex items-center text-gray-500">
                                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ appointment.duration }} minutes
                                            </div>
                                        </div>
                                        <p v-if="appointment.description" class="mt-3 text-gray-600">
                                            {{ appointment.description }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end space-y-4">
                                    <span :class="[
                                        getStatusColor(appointment.status),
                                        'px-4 py-2 rounded-full text-sm font-medium border'
                                    ]">
                                        {{ appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1) }}
                                    </span>
                                    <Link
                                        :href="route('appointments.show', appointment.id)"
                                        class="inline-flex items-center px-4 py-2 border border-orange-500 text-sm font-medium rounded-lg text-orange-600 bg-white hover:bg-orange-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200"
                                    >
                                        View Details
                                        <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
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

<style>
.appointment-card {
    transition: all 0.3s ease;
}

.appointment-card:hover {
    transform: translateY(-2px);
}
</style> 