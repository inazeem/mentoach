<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { format } from 'date-fns';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';

const props = defineProps({
    upcomingAppointments: Array,
    pastAppointments: Array,
    stats: Object,
    enquiriesData: Object,
    role: String,
    calendarEvents: Array,
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

const calendarOptions = {
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin, listPlugin],
    initialView: 'dayGridMonth',
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },
    events: props.calendarEvents,
    editable: false,
    selectable: true,
    selectMirror: true,
    dayMaxEvents: true,
    eventClick: (info) => {
        window.location = route('appointments.show', info.event.id);
    },
    eventDidMount: (info) => {
        // Add tooltip with extended information
        const event = info.event;
        const tooltip = document.createElement('div');
        tooltip.className = 'calendar-tooltip';
        tooltip.innerHTML = `
            <strong>${event.title}</strong><br>
            Status: ${event.extendedProps.status}<br>
            Mentor: ${event.extendedProps.mentor}<br>
            Client: ${event.extendedProps.user}<br>
            Duration: ${event.extendedProps.duration} minutes
        `;
        info.el.title = tooltip.textContent;
    }
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Welcome to Your Dashboard
                </h2>
                <div class="text-sm text-gray-500">
                    {{ new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 rounded-xl p-6">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-indigo-100 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-indigo-600">{{ stats.total }}</div>
                                <div class="text-sm font-medium text-gray-600">Total Appointments</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 rounded-xl p-6">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-yellow-100 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-yellow-600">{{ stats.upcoming }}</div>
                                <div class="text-sm font-medium text-gray-600">Upcoming</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 rounded-xl p-6">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-green-100 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-green-600">{{ stats.completed }}</div>
                                <div class="text-sm font-medium text-gray-600">Completed</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 rounded-xl p-6">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-red-100 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-red-600">{{ stats.cancelled }}</div>
                                <div class="text-sm font-medium text-gray-600">Cancelled</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar Section -->
                <div class="bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Appointment Calendar</h3>
                        <Link :href="route('appointments.create')" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            New Appointment
                        </Link>
                    </div>
                    <FullCalendar :options="calendarOptions" class="calendar-container" />
                </div>

                <!-- Activity Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Recent Activity -->
                    <div class="bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 rounded-xl p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Recent Activity</h3>
                            <Link :href="route('appointments.index')" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                View All
                            </Link>
                        </div>
                        <div class="space-y-6">
                            <!-- Upcoming Appointments Preview -->
                            <div v-if="upcomingAppointments.length > 0">
                                <h4 class="font-semibold text-gray-800 mb-4">Upcoming Appointments</h4>
                                <div class="space-y-3">
                                    <div v-for="appointment in upcomingAppointments.slice(0, 3)" :key="appointment.id" 
                                        class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        {{ appointment.title }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ formatDate(appointment.appointment_date) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <Link :href="route('appointments.show', appointment.id)"
                                            class="ml-4 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                            View
                                        </Link>
                                    </div>
                                </div>
                            </div>

                            <!-- Enquiries Section -->
                            <div v-if="showEnquiries" class="mt-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-semibold text-gray-800">Recent Enquiries</h4>
                                    <Link :href="route('enquiries.index')" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                        View All
                                    </Link>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <div class="text-2xl font-bold text-indigo-600">{{ enquiriesData.stats.pending }}</div>
                                        <div class="text-sm font-medium text-gray-600">Pending</div>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <div class="text-2xl font-bold text-green-600">{{ enquiriesData.stats.assigned }}</div>
                                        <div class="text-sm font-medium text-gray-600">Assigned</div>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <div v-for="enquiry in enquiriesData.recent" :key="enquiry.id" 
                                        class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        {{ enquiry.subject }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ enquiry.name }}
                                                    </p>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                        :class="{
                                                            'bg-yellow-100 text-yellow-800': enquiry.status === 'pending',
                                                            'bg-green-100 text-green-800': enquiry.status === 'assigned',
                                                            'bg-red-100 text-red-800': enquiry.status === 'cancelled'
                                                        }">
                                                        {{ enquiry.status }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <Link :href="route('enquiries.show', enquiry.id)"
                                            class="ml-4 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                            View
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 rounded-xl p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <Link :href="route('appointments.create')"
                                class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900">New Appointment</span>
                            </Link>
                            <Link :href="route('enquiries.index')"
                                class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900">View Enquiries</span>
                            </Link>
                            <Link :href="route('profile.edit')"
                                class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900">Edit Profile</span>
                            </Link>
                            <Link :href="route('appointments.index')"
                                class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900">All Appointments</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* FullCalendar Custom Styles */
.calendar-container {
    margin-top: 1rem;
    font-family: 'Inter', sans-serif;
}

:root {
    --fc-border-color: #e5e7eb;
    --fc-button-text-color: #ffffff;
    --fc-button-bg-color: #4f46e5;
    --fc-button-border-color: #4338ca;
    --fc-button-hover-bg-color: #4338ca;
    --fc-button-hover-border-color: #3730a3;
    --fc-button-active-bg-color: #3730a3;
    --fc-today-bg-color: rgba(79, 70, 229, 0.1);
    --fc-event-bg-color: #4f46e5;
    --fc-event-border-color: #4338ca;
    --fc-event-text-color: #ffffff;
    --fc-list-event-hover-bg-color: #f3f4f6;
}

.fc .fc-button {
    padding: 0.5rem 1rem;
    font-weight: 500;
    border-radius: 0.375rem;
    transition: all 0.2s;
}

.fc .fc-button-primary:not(:disabled).fc-button-active,
.fc .fc-button-primary:not(:disabled):active {
    background-color: var(--fc-button-active-bg-color);
    border-color: var(--fc-button-hover-border-color);
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

.fc .fc-button-primary:hover {
    background-color: var(--fc-button-hover-bg-color);
    border-color: var(--fc-button-hover-border-color);
}

.fc .fc-button-primary {
    background-color: var(--fc-button-bg-color);
    border-color: var(--fc-button-border-color);
}

.fc-event {
    cursor: pointer;
    border-radius: 0.25rem;
    padding: 0.125rem 0.25rem;
    font-size: 0.875rem;
    transition: transform 0.1s ease-in-out;
}

.fc-event:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.fc .fc-toolbar-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
}

.fc th {
    padding: 1rem 0.75rem;
    font-weight: 600;
    color: #4b5563;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
}

.fc-theme-standard td, .fc-theme-standard th {
    border-color: var(--fc-border-color);
}

.fc .fc-daygrid-day.fc-day-today {
    background-color: var(--fc-today-bg-color);
}

.fc .fc-daygrid-day-number,
.fc .fc-col-header-cell-cushion {
    color: #4b5563;
    text-decoration: none;
    padding: 0.75rem;
}

.fc .fc-list-event:hover td {
    background-color: var(--fc-list-event-hover-bg-color);
}

.fc-direction-ltr .fc-list-day-text,
.fc-direction-ltr .fc-list-day-side-text {
    color: #1f2937;
    font-weight: 600;
}

.calendar-tooltip {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    padding: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    font-size: 0.875rem;
    z-index: 50;
}
</style>
