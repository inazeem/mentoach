<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    appointment: Object,
});

const updateForm = useForm({
    status: props.appointment.status,
    meeting_link: props.appointment.meeting_link,
});

const deleteForm = useForm({});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-GB', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const getInitials = (name) => {
    return name
        .split(' ')
        .map(word => word[0])
        .join('')
        .toUpperCase();
};

const timeline = computed(() => {
    const events = [
        {
            type: 'created',
            title: 'Appointment Created',
            description: `Appointment scheduled with ${props.appointment.mentor.name}`,
            date: props.appointment.created_at,
            iconBackground: 'bg-gray-400',
            icon: {
                class: 'text-white',
                path: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'
            }
        }
    ];

    if (props.appointment.status === 'confirmed') {
        events.push({
            type: 'confirmed',
            title: 'Appointment Confirmed',
            description: 'The appointment has been confirmed',
            date: props.appointment.updated_at,
            iconBackground: 'bg-blue-500',
            icon: {
                class: 'text-white',
                path: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
            }
        });
    }

    if (props.appointment.status === 'completed') {
        events.push({
            type: 'completed',
            title: 'Appointment Completed',
            description: 'The appointment has been marked as completed',
            date: props.appointment.updated_at,
            iconBackground: 'bg-green-500',
            icon: {
                class: 'text-white',
                path: 'M5 13l4 4L19 7'
            }
        });
    }

    if (props.appointment.status === 'cancelled') {
        events.push({
            type: 'cancelled',
            title: 'Appointment Cancelled',
            description: 'The appointment has been cancelled',
            date: props.appointment.updated_at,
            iconBackground: 'bg-red-500',
            icon: {
                class: 'text-white',
                path: 'M6 18L18 6M6 6l12 12'
            }
        });
    }

    return events.sort((a, b) => new Date(b.date) - new Date(a.date));
});

const updateAppointment = () => {
    updateForm.put(route('appointments.update', props.appointment.id), {
        preserveScroll: true,
    });
};

const deleteAppointment = () => {
    if (confirm('Are you sure you want to cancel this appointment?')) {
        deleteForm.delete(route('appointments.destroy', props.appointment.id));
    }
};
</script>

<template>
    <Head title="Appointment Details" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Appointment Details
                </h2>
                <Link :href="route('appointments.index')"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Appointments
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Main Appointment Details -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Appointment Information -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    Appointment Information
                                </h3>
                            </div>
                            <div class="px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Title</label>
                                        <div class="mt-1 text-sm text-gray-900">{{ appointment.title }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Duration</label>
                                        <div class="mt-1 text-sm text-gray-900">{{ appointment.duration }} minutes</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Date & Time</label>
                                        <div class="mt-1 text-sm text-gray-900">{{ formatDate(appointment.appointment_date) }}</div>
                                    </div>
                                    <div v-if="appointment.meeting_link">
                                        <label class="block text-sm font-medium text-gray-500">Meeting Link</label>
                                        <div class="mt-1 text-sm text-gray-900">
                                            <a :href="appointment.meeting_link" target="_blank" class="text-orange-600 hover:text-orange-700">
                                                Join Meeting
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6" v-if="appointment.description">
                                    <label class="block text-sm font-medium text-gray-500">Description</label>
                                    <div class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ appointment.description }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Participant Information -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    Participant Information
                                </h3>
                            </div>
                            <div class="px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
                                    <!-- Mentor Info -->
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-4">Mentor</h4>
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-orange-100">
                                                    <span class="text-lg font-medium leading-none text-orange-700">
                                                        {{ getInitials(appointment.mentor.name) }}
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ appointment.mentor.name }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    {{ appointment.mentor.email }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Client Info -->
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-4">Client</h4>
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-orange-100">
                                                    <span class="text-lg font-medium leading-none text-orange-700">
                                                        {{ getInitials(appointment.user.name) }}
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ appointment.user.name }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    {{ appointment.user.email }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    Activity Timeline
                                </h3>
                            </div>
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flow-root">
                                    <ul role="list" class="-mb-8">
                                        <li v-for="(activity, index) in timeline" :key="index">
                                            <div class="relative pb-8">
                                                <span v-if="index !== timeline.length - 1" class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span :class="[
                                                            'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white',
                                                            activity.iconBackground
                                                        ]">
                                                            <svg class="w-5 h-5 text-white" :class="activity.icon.class" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="activity.icon.path" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ activity.title }}
                                                        </div>
                                                        <div class="mt-1 text-sm text-gray-500">
                                                            {{ activity.description }}
                                                        </div>
                                                        <div class="mt-1 text-sm text-gray-500">
                                                            {{ formatDate(activity.date) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Side Panel -->
                    <div class="space-y-6">
                        <!-- Status Card -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Status</h3>
                                <div class="flex items-center space-x-2">
                                    <span :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        {
                                            'bg-yellow-100 text-yellow-800': appointment.status === 'pending',
                                            'bg-blue-100 text-blue-800': appointment.status === 'confirmed',
                                            'bg-green-100 text-green-800': appointment.status === 'completed',
                                            'bg-red-100 text-red-800': appointment.status === 'cancelled'
                                        }
                                    ]">
                                        {{ appointment.status }}
                                    </span>
                                </div>

                                <!-- Update Form for Mentors -->
                                <div v-if="$page.props.auth.user.id === appointment.mentor_id" class="mt-6 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Update Status</label>
                                        <select v-model="updateForm.status"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                            <option value="pending">Pending</option>
                                            <option value="confirmed">Confirmed</option>
                                            <option value="completed">Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Meeting Link</label>
                                        <input type="url" v-model="updateForm.meeting_link"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                            placeholder="https://meet.google.com/...">
                                    </div>

                                    <button type="button"
                                        @click="updateAppointment"
                                        :disabled="updateForm.processing"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50">
                                        Update Appointment
                                    </button>
                                </div>

                                <!-- Cancel Button for Clients -->
                                <div v-if="$page.props.auth.user.id === appointment.user_id && appointment.status === 'pending'"
                                    class="mt-6">
                                    <button type="button"
                                        @click="deleteAppointment"
                                        :disabled="deleteForm.processing"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Cancel Appointment
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Calendar Preview -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Date & Time</h3>
                                <div class="text-center p-4 bg-gray-50 rounded-lg">
                                    <div class="text-3xl font-bold text-gray-900">
                                        {{ new Date(appointment.appointment_date).toLocaleDateString('en-US', { day: 'numeric' }) }}
                                    </div>
                                    <div class="text-sm font-medium text-gray-500">
                                        {{ new Date(appointment.appointment_date).toLocaleDateString('en-US', { month: 'long', year: 'numeric' }) }}
                                    </div>
                                    <div class="mt-2 text-lg font-semibold text-orange-600">
                                        {{ new Date(appointment.appointment_date).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }) }}
                                    </div>
                                    <div class="mt-1 text-sm text-gray-500">
                                        {{ appointment.duration }} minutes
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