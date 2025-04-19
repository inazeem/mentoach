<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';

const props = defineProps({
    mentors: Array,
});

const form = useForm({
    mentor_id: '',
    title: '',
    description: '',
    appointment_date: '',
    appointment_time: '',
    duration: 60,
});

const submit = () => {
    const dateTime = `${form.appointment_date}T${form.appointment_time}`;
    form.post(route('appointments.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Book Appointment" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Book Appointment
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <InputLabel for="mentor" value="Select Mentor" />
                                <select
                                    id="mentor"
                                    v-model="form.mentor_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="">Choose a mentor</option>
                                    <option
                                        v-for="mentor in mentors"
                                        :key="mentor.id"
                                        :value="mentor.id"
                                    >
                                        {{ mentor.name }}
                                    </option>
                                </select>
                                <InputError :message="form.errors.mentor_id" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="title" value="Appointment Title" />
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    required
                                />
                                <InputError :message="form.errors.title" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="description" value="Description (Optional)" />
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    rows="3"
                                ></textarea>
                                <InputError :message="form.errors.description" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <InputLabel for="date" value="Date" />
                                    <TextInput
                                        id="date"
                                        type="date"
                                        class="mt-1 block w-full"
                                        v-model="form.appointment_date"
                                        required
                                    />
                                    <InputError :message="form.errors.appointment_date" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="time" value="Time" />
                                    <TextInput
                                        id="time"
                                        type="time"
                                        class="mt-1 block w-full"
                                        v-model="form.appointment_time"
                                        required
                                    />
                                    <InputError :message="form.errors.appointment_time" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <InputLabel for="duration" value="Duration (minutes)" />
                                <select
                                    id="duration"
                                    v-model="form.duration"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="30">30 minutes</option>
                                    <option value="60">1 hour</option>
                                    <option value="90">1.5 hours</option>
                                    <option value="120">2 hours</option>
                                </select>
                                <InputError :message="form.errors.duration" class="mt-2" />
                            </div>

                            <div class="flex justify-end">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Book Appointment
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 