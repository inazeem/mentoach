<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Enquiry Details
                </h2>
                <Link :href="route('enquiries.index')"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Enquiries
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Main Enquiry Details -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Client Information -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    Client Information
                                </h3>
                            </div>
                            <div class="px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Full Name</label>
                                        <div class="mt-1 text-sm text-gray-900">{{ enquiry.name }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Email Address</label>
                                        <div class="mt-1 text-sm text-gray-900">
                                            <a :href="'mailto:' + enquiry.email" class="text-orange-600 hover:text-orange-700">
                                                {{ enquiry.email }}
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Phone Number</label>
                                        <div class="mt-1 text-sm text-gray-900">
                                            <a :href="'tel:' + enquiry.phone" class="text-orange-600 hover:text-orange-700">
                                                {{ enquiry.phone }}
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Submitted On</label>
                                        <div class="mt-1 text-sm text-gray-900">
                                            {{ formatDate(enquiry.created_at) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enquiry Details -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    Enquiry Details
                                </h3>
                            </div>
                            <div class="px-4 py-5 sm:p-6">
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Service Requested</label>
                                        <div class="mt-1 text-sm text-gray-900">{{ enquiry.service }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Subject</label>
                                        <div class="mt-1 text-sm text-gray-900">{{ enquiry.subject }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Message</label>
                                        <div class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ enquiry.message }}</div>
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
                                                            {
                                                                'bg-gray-400': activity.type === 'created',
                                                                'bg-blue-500': activity.type === 'assigned',
                                                                'bg-green-500': activity.type === 'converted',
                                                                'bg-red-500': activity.type === 'rejected'
                                                            }
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
                                            'bg-yellow-100 text-yellow-800': enquiry.status === 'pending',
                                            'bg-blue-100 text-blue-800': enquiry.status === 'assigned',
                                            'bg-green-100 text-green-800': enquiry.status === 'converted',
                                            'bg-red-100 text-red-800': enquiry.status === 'rejected'
                                        }
                                    ]">
                                        {{ enquiry.status }}
                                    </span>
                                </div>

                                <div class="mt-6 space-y-4">
                                    <button v-if="enquiry.status === 'pending'"
                                        @click="openAssignModal"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                        Assign to Mentor
                                    </button>
                                    <button v-if="enquiry.status === 'assigned'"
                                        @click="convertToAppointment"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Convert to Appointment
                                    </button>
                                    <button v-if="enquiry.status === 'pending'"
                                        @click="rejectEnquiry"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Reject Enquiry
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Assigned Mentor -->
                        <div v-if="enquiry.assigned_mentor" class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Assigned Mentor</h3>
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-orange-100">
                                            <span class="text-lg font-medium leading-none text-orange-700">
                                                {{ getInitials(enquiry.assigned_mentor.name) }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ enquiry.assigned_mentor.name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ enquiry.assigned_mentor.email }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assign Modal -->
                <Modal :show="showAssignModal" @close="closeAssignModal">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Assign Mentor
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Select Mentor</label>
                                <select v-model="selectedMentorId"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="">Choose a mentor</option>
                                    <option v-for="mentor in mentors" :key="mentor.id" :value="mentor.id">
                                        {{ mentor.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button"
                                    @click="closeAssignModal"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Cancel
                                </button>
                                <button type="button"
                                    @click="assignMentor"
                                    :disabled="!selectedMentorId"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Assign
                                </button>
                            </div>
                        </div>
                    </div>
                </Modal>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    enquiry: Object,
    mentors: Array
});

const showAssignModal = ref(false);
const selectedMentorId = ref('');

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
            title: 'Enquiry Submitted',
            description: `${props.enquiry.name} submitted a new enquiry for ${props.enquiry.service}`,
            date: props.enquiry.created_at,
            icon: {
                class: 'text-white',
                path: 'M12 4v16m8-8H4'
            }
        }
    ];

    if (props.enquiry.assigned_at) {
        events.push({
            type: 'assigned',
            title: 'Assigned to Mentor',
            description: `Enquiry assigned to ${props.enquiry.assigned_mentor.name}`,
            date: props.enquiry.assigned_at,
            icon: {
                class: 'text-white',
                path: 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'
            }
        });
    }

    if (props.enquiry.converted_at) {
        events.push({
            type: 'converted',
            title: 'Converted to Appointment',
            description: 'Enquiry was successfully converted to an appointment',
            date: props.enquiry.converted_at,
            icon: {
                class: 'text-white',
                path: 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'
            }
        });
    }

    if (props.enquiry.rejected_at) {
        events.push({
            type: 'rejected',
            title: 'Enquiry Rejected',
            description: 'Enquiry was rejected',
            date: props.enquiry.rejected_at,
            icon: {
                class: 'text-white',
                path: 'M6 18L18 6M6 6l12 12'
            }
        });
    }

    return events.sort((a, b) => new Date(b.date) - new Date(a.date));
});

const openAssignModal = () => {
    showAssignModal.value = true;
};

const closeAssignModal = () => {
    showAssignModal.value = false;
    selectedMentorId.value = '';
};

const assignMentor = () => {
    if (!selectedMentorId.value) return;

    useForm({
        mentor_id: selectedMentorId.value
    }).post(route('enquiries.assign', props.enquiry.id), {
        onSuccess: () => {
            closeAssignModal();
        }
    });
};

const convertToAppointment = () => {
    if (!confirm('Are you sure you want to convert this enquiry to an appointment?')) return;

    useForm().post(route('enquiries.convert', props.enquiry.id));
};

const rejectEnquiry = () => {
    if (!confirm('Are you sure you want to reject this enquiry?')) return;

    useForm().post(route('enquiries.reject', props.enquiry.id));
};
</script> 