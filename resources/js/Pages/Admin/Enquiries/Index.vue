<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Manage Enquiries
                </h2>
                <div class="flex items-center space-x-4">
                    <div class="flex space-x-2">
                        <div v-for="(count, status) in statusCounts" :key="status"
                            class="flex items-center space-x-1">
                            <span :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                {
                                    'bg-yellow-100 text-yellow-800': status === 'pending',
                                    'bg-blue-100 text-blue-800': status === 'assigned',
                                    'bg-green-100 text-green-800': status === 'converted',
                                    'bg-red-100 text-red-800': status === 'rejected'
                                }
                            ]">
                                {{ count }}
                            </span>
                            <span class="text-xs text-gray-500 capitalize">{{ status }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Filters Card -->
                <div class="mb-6 bg-white rounded-lg shadow-sm p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select v-model="filters.status" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="assigned">Assigned</option>
                                <option value="converted">Converted</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                            <select v-model="filters.service"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                <option value="">All Services</option>
                                <option v-for="service in services" :key="service" :value="service">
                                    {{ service }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                            <Datepicker v-model="filters.dateRange"
                                range
                                :enable-time-picker="false"
                                placeholder="Select date range"
                                class="w-full text-sm"
                                :clearable="true"
                                auto-apply />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative">
                                <input type="text" v-model="filters.search"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 pl-10 text-sm"
                                    placeholder="Search by name, email, or subject">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enquiries Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="enquiry in filteredEnquiries" :key="enquiry.id"
                        class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                        <!-- Card Header -->
                        <div class="px-4 py-3 bg-gray-50 border-b flex items-center justify-between">
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
                                <span class="text-sm text-gray-500">{{ formatDate(enquiry.created_at) }}</span>
                            </div>
                            <Link :href="route('enquiries.show', enquiry.id)"
                                class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                                View Details
                            </Link>
                        </div>

                        <!-- Card Content -->
                        <div class="p-4 space-y-4">
                            <div>
                                <h3 class="font-medium text-gray-900">{{ enquiry.name }}</h3>
                                <div class="mt-1 flex items-center space-x-2 text-sm text-gray-500">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ enquiry.email }}</span>
                                </div>
                                <div class="mt-1 flex items-center space-x-2 text-sm text-gray-500">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>{{ enquiry.phone }}</span>
                                </div>
                            </div>

                            <div class="pt-2 border-t">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-500">Service:</span>
                                    <span class="text-sm text-gray-900">{{ enquiry.service }}</span>
                                </div>
                                <div class="mt-1">
                                    <h4 class="text-sm font-medium text-gray-500">Subject:</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ enquiry.subject }}</p>
                                </div>
                            </div>

                            <div v-if="enquiry.assigned_mentor" class="pt-2 border-t">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-500">Assigned to:</span>
                                    <span class="text-sm text-gray-900">{{ enquiry.assigned_mentor.name }}</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="pt-4 border-t flex justify-end space-x-2">
                                <button v-if="enquiry.status === 'pending'"
                                    @click="openAssignModal(enquiry)"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Assign
                                </button>
                                <button v-if="enquiry.status === 'assigned'"
                                    @click="convertToAppointment(enquiry)"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Convert
                                </button>
                                <button v-if="enquiry.status === 'pending'"
                                    @click="rejectEnquiry(enquiry)"
                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Reject
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="filteredEnquiries.length === 0" class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No enquiries found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or search terms.</p>
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
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

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
    search: '',
    dateRange: null
});

const showAssignModal = ref(false);
const selectedMentorId = ref('');
const selectedEnquiry = ref(null);

const statusCounts = computed(() => {
    const counts = {
        pending: 0,
        assigned: 0,
        converted: 0,
        rejected: 0
    };
    
    props.enquiries.data.forEach(enquiry => {
        counts[enquiry.status]++;
    });
    
    return counts;
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-GB', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
    });
};

const filteredEnquiries = computed(() => {
    return props.enquiries.data.filter(enquiry => {
        const matchesStatus = !filters.value.status || enquiry.status === filters.value.status;
        const matchesService = !filters.value.service || enquiry.service === filters.value.service;
        const matchesSearch = !filters.value.search || 
            enquiry.name.toLowerCase().includes(filters.value.search.toLowerCase()) ||
            enquiry.email.toLowerCase().includes(filters.value.search.toLowerCase()) ||
            enquiry.subject.toLowerCase().includes(filters.value.search.toLowerCase());
        
        let matchesDate = true;
        if (filters.value.dateRange) {
            const enquiryDate = new Date(enquiry.created_at);
            const startDate = new Date(filters.value.dateRange[0]);
            const endDate = new Date(filters.value.dateRange[1]);
            matchesDate = enquiryDate >= startDate && enquiryDate <= endDate;
        }
        
        return matchesStatus && matchesService && matchesSearch && matchesDate;
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