<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Manage Enquiries
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Filters -->
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select v-model="filters.status" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="assigned">Assigned</option>
                                    <option value="converted">Converted</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Service</label>
                                <select v-model="filters.service"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Services</option>
                                    <option v-for="service in services" :key="service" :value="service">
                                        {{ service }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" v-model="filters.search"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Search by name, email, or subject">
                            </div>
                        </div>

                        <!-- Enquiries Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Client Details
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Service & Subject
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Assigned To
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="enquiry in filteredEnquiries" :key="enquiry.id">
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ enquiry.name }}</div>
                                            <div class="text-sm text-gray-500">{{ enquiry.email }}</div>
                                            <div class="text-sm text-gray-500">{{ enquiry.phone }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ enquiry.service }}</div>
                                            <div class="text-sm text-gray-500">{{ enquiry.subject }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span :class="[
                                                'inline-flex rounded-full px-2 text-xs font-semibold leading-5',
                                                {
                                                    'bg-yellow-100 text-yellow-800': enquiry.status === 'pending',
                                                    'bg-blue-100 text-blue-800': enquiry.status === 'assigned',
                                                    'bg-green-100 text-green-800': enquiry.status === 'converted',
                                                    'bg-red-100 text-red-800': enquiry.status === 'rejected'
                                                }
                                            ]">
                                                {{ enquiry.status }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            {{ enquiry.assigned_mentor?.name || 'Not Assigned' }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                                            <div class="flex space-x-2">
                                                <button v-if="enquiry.status === 'pending'"
                                                    @click="openAssignModal(enquiry)"
                                                    class="text-blue-600 hover:text-blue-900">
                                                    Assign
                                                </button>
                                                <button v-if="enquiry.status === 'assigned'"
                                                    @click="convertToAppointment(enquiry)"
                                                    class="text-green-600 hover:text-green-900">
                                                    Convert
                                                </button>
                                                <button v-if="enquiry.status === 'pending'"
                                                    @click="rejectEnquiry(enquiry)"
                                                    class="text-red-600 hover:text-red-900">
                                                    Reject
                                                </button>
                                                <Link :href="route('enquiries.show', enquiry.id)"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                    View
                                                </Link>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            <Pagination :links="enquiries.links" />
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
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    enquiries: Object,
    mentors: Array
});

const services = [
    'Career Coaching',
    'Mentorship for Students',
    'Motivational Speaking',
    'Workshops and Group Coaching'
];

const filters = ref({
    status: '',
    service: '',
    search: ''
});

const showAssignModal = ref(false);
const selectedMentorId = ref('');
const selectedEnquiry = ref(null);

const filteredEnquiries = computed(() => {
    return props.enquiries.data.filter(enquiry => {
        const matchesStatus = !filters.value.status || enquiry.status === filters.value.status;
        const matchesService = !filters.value.service || enquiry.service === filters.value.service;
        const matchesSearch = !filters.value.search || 
            enquiry.name.toLowerCase().includes(filters.value.search.toLowerCase()) ||
            enquiry.email.toLowerCase().includes(filters.value.search.toLowerCase()) ||
            enquiry.subject.toLowerCase().includes(filters.value.search.toLowerCase());
        
        return matchesStatus && matchesService && matchesSearch;
    });
});

const openAssignModal = (enquiry) => {
    selectedEnquiry.value = enquiry;
    showAssignModal.value = true;
};

const closeAssignModal = () => {
    showAssignModal.value = false;
    selectedMentorId.value = '';
    selectedEnquiry.value = null;
};

const assignMentor = () => {
    if (!selectedMentorId.value || !selectedEnquiry.value) return;

    useForm({
        mentor_id: selectedMentorId.value
    }).post(route('enquiries.assign', selectedEnquiry.value.id), {
        onSuccess: () => {
            closeAssignModal();
        }
    });
};

const convertToAppointment = (enquiry) => {
    if (!confirm('Are you sure you want to convert this enquiry to an appointment?')) return;

    useForm().post(route('enquiries.convert', enquiry.id));
};

const rejectEnquiry = (enquiry) => {
    if (!confirm('Are you sure you want to reject this enquiry?')) return;

    useForm().post(route('enquiries.reject', enquiry.id));
};
</script> 