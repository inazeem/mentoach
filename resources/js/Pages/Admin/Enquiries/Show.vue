<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Enquiry Details
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Back Button -->
                        <Link :href="route('enquiries.index')" 
                            class="mb-6 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Enquiries
                        </Link>

                        <!-- Status Badge -->
                        <div class="mb-6">
                            <span :class="[
                                'inline-flex rounded-full px-3 py-1 text-sm font-semibold',
                                {
                                    'bg-yellow-100 text-yellow-800': enquiry.status === 'pending',
                                    'bg-blue-100 text-blue-800': enquiry.status === 'assigned',
                                    'bg-green-100 text-green-800': enquiry.status === 'converted',
                                    'bg-red-100 text-red-800': enquiry.status === 'rejected'
                                }
                            ]">
                                {{ enquiry.status.charAt(0).toUpperCase() + enquiry.status.slice(1) }}
                            </span>
                        </div>

                        <!-- Enquiry Details -->
                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Client Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Client Information</h3>
                                <div class="rounded-lg bg-gray-50 p-4">
                                    <dl class="space-y-2">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                                            <dd class="text-sm text-gray-900">{{ enquiry.name }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                                            <dd class="text-sm text-gray-900">{{ enquiry.email }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                            <dd class="text-sm text-gray-900">{{ enquiry.phone }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                            <!-- Service Details -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Service Details</h3>
                                <div class="rounded-lg bg-gray-50 p-4">
                                    <dl class="space-y-2">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Service</dt>
                                            <dd class="text-sm text-gray-900">{{ enquiry.service }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Subject</dt>
                                            <dd class="text-sm text-gray-900">{{ enquiry.subject }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Preferred Date</dt>
                                            <dd class="text-sm text-gray-900">{{ formatDate(enquiry.preferred_date) }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                            <!-- Message -->
                            <div class="md:col-span-2 space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Message</h3>
                                <div class="rounded-lg bg-gray-50 p-4">
                                    <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ enquiry.message || 'No message provided.' }}</p>
                                </div>
                            </div>

                            <!-- Assigned Mentor -->
                            <div class="md:col-span-2 space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Assigned Mentor</h3>
                                <div class="rounded-lg bg-gray-50 p-4">
                                    <div v-if="enquiry.assigned_mentor" class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                                                <span class="text-lg font-medium leading-none text-indigo-700">
                                                    {{ enquiry.assigned_mentor.name.charAt(0) }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ enquiry.assigned_mentor.name }}</div>
                                            <div class="text-sm text-gray-500">{{ enquiry.assigned_mentor.email }}</div>
                                        </div>
                                    </div>
                                    <p v-else class="text-sm text-gray-500">No mentor assigned</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <button v-if="enquiry.status === 'pending'"
                                @click="openAssignModal"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Assign Mentor
                            </button>
                            <button v-if="enquiry.status === 'assigned'"
                                @click="convertToAppointment"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Convert to Appointment
                            </button>
                            <button v-if="enquiry.status === 'pending'"
                                @click="rejectEnquiry"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Reject
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assign Mentor Modal -->
        <Modal :show="showAssignModal" @close="closeAssignModal">
            <div class="p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Assign Mentor
                </h3>
                <div class="mt-4">
                    <select v-model="selectedMentorId"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a Mentor</option>
                        <option v-for="mentor in mentors" :key="mentor.id" :value="mentor.id">
                            {{ mentor.name }}
                        </option>
                    </select>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <SecondaryButton @click="closeAssignModal">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton @click="assignMentor" :disabled="!selectedMentorId">
                        Assign
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    enquiry: Object,
    mentors: Array
});

const showAssignModal = ref(false);
const selectedMentorId = ref('');

const formatDate = (date) => {
    if (!date) return 'Not specified';
    return new Date(date).toLocaleString();
};

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