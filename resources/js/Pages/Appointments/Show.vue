<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { ref } from 'vue';

const props = defineProps({
    appointment: Object,
});

const updateForm = useForm({
    status: props.appointment.status,
    meeting_link: props.appointment.meeting_link,
});

const deleteForm = useForm({});

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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Appointment Details
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-6">
                            <h3 class="text-2xl font-medium">{{ appointment.title }}</h3>
                            <p class="text-gray-600 mt-2">
                                With {{ appointment.mentor.name }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium mb-2">Appointment Details</h4>
                                <div class="space-y-2">
                                    <p>
                                        <span class="text-gray-600">Date & Time:</span>
                                        {{ new Date(appointment.appointment_date).toLocaleString() }}
                                    </p>
                                    <p>
                                        <span class="text-gray-600">Duration:</span>
                                        {{ appointment.duration }} minutes
                                    </p>
                                    <p>
                                        <span class="text-gray-600">Status:</span>
                                        <span
                                            :class="{
                                                'text-yellow-600': appointment.status === 'pending',
                                                'text-green-600': appointment.status === 'confirmed',
                                                'text-red-600': appointment.status === 'cancelled',
                                                'text-blue-600': appointment.status === 'completed'
                                            }"
                                            class="font-medium"
                                        >
                                            {{ appointment.status }}
                                        </span>
                                    </p>
                                </div>

                                <div v-if="appointment.description" class="mt-4">
                                    <h4 class="font-medium mb-2">Description</h4>
                                    <p class="text-gray-600">{{ appointment.description }}</p>
                                </div>
                            </div>

                            <div v-if="$page.props.auth.user.id === appointment.mentor_id">
                                <h4 class="font-medium mb-2">Update Appointment</h4>
                                <form @submit.prevent="updateAppointment" class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            Status
                                        </label>
                                        <select
                                            v-model="updateForm.status"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        >
                                            <option value="pending">Pending</option>
                                            <option value="confirmed">Confirmed</option>
                                            <option value="cancelled">Cancelled</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            Meeting Link
                                        </label>
                                        <input
                                            type="url"
                                            v-model="updateForm.meeting_link"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            placeholder="https://meet.google.com/..."
                                        />
                                    </div>

                                    <div>
                                        <PrimaryButton :disabled="updateForm.processing">
                                            Update Appointment
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div v-if="$page.props.auth.user.id === appointment.user_id && appointment.status === 'pending'"
                            class="mt-6 border-t pt-6">
                            <DangerButton @click="deleteAppointment" :disabled="deleteForm.processing">
                                Cancel Appointment
                            </DangerButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 