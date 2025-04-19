<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    smtp: {
        type: Object,
        required: true
    },
    recaptcha: {
        type: Object,
        required: true
    }
});

const smtpForm = useForm({
    host: props.smtp.host || '',
    port: props.smtp.port || '',
    username: props.smtp.username || '',
    password: props.smtp.password || '',
    encryption: props.smtp.encryption || 'tls',
    from_address: props.smtp.from_address || '',
    from_name: props.smtp.from_name || ''
});

const recaptchaForm = useForm({
    site_key: props.recaptcha.site_key || '',
    secret_key: props.recaptcha.secret_key || '',
    is_enabled: props.recaptcha.is_enabled || false
});

const updateSmtp = () => {
    smtpForm.post(route('admin.settings.smtp.update'), {
        preserveScroll: true
    });
};

const testSmtp = () => {
    smtpForm.post(route('admin.settings.smtp.test'), {
        preserveScroll: true
    });
};

const updateRecaptcha = () => {
    recaptchaForm.post(route('admin.settings.recaptcha.update'), {
        preserveScroll: true
    });
};
</script>

<template>
    <Head title="Settings" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Settings</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- SMTP Settings -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">SMTP Configuration</h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Configure your email sending settings.
                            </p>
                        </header>

                        <form @submit.prevent="updateSmtp" class="mt-6 space-y-6">
                            <div>
                                <InputLabel for="host" value="SMTP Host" />
                                <TextInput
                                    id="host"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="smtpForm.host"
                                />
                                <InputError :message="smtpForm.errors.host" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="port" value="SMTP Port" />
                                <TextInput
                                    id="port"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="smtpForm.port"
                                />
                                <InputError :message="smtpForm.errors.port" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="username" value="SMTP Username" />
                                <TextInput
                                    id="username"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="smtpForm.username"
                                />
                                <InputError :message="smtpForm.errors.username" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="password" value="SMTP Password" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="smtpForm.password"
                                />
                                <InputError :message="smtpForm.errors.password" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="encryption" value="Encryption" />
                                <select
                                    id="encryption"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="smtpForm.encryption"
                                >
                                    <option value="tls">TLS</option>
                                    <option value="ssl">SSL</option>
                                </select>
                                <InputError :message="smtpForm.errors.encryption" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="from_address" value="From Address" />
                                <TextInput
                                    id="from_address"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="smtpForm.from_address"
                                />
                                <InputError :message="smtpForm.errors.from_address" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="from_name" value="From Name" />
                                <TextInput
                                    id="from_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="smtpForm.from_name"
                                />
                                <InputError :message="smtpForm.errors.from_name" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="smtpForm.processing">Save</PrimaryButton>
                                <PrimaryButton type="button" @click="testSmtp" :disabled="smtpForm.processing">
                                    Test Connection
                                </PrimaryButton>
                            </div>
                        </form>
                    </section>
                </div>

                <!-- reCAPTCHA Settings -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">reCAPTCHA Configuration</h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Configure Google reCAPTCHA settings for form protection.
                            </p>
                        </header>

                        <form @submit.prevent="updateRecaptcha" class="mt-6 space-y-6">
                            <div>
                                <InputLabel for="site_key" value="Site Key" />
                                <TextInput
                                    id="site_key"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="recaptchaForm.site_key"
                                />
                                <InputError :message="recaptchaForm.errors.site_key" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="secret_key" value="Secret Key" />
                                <TextInput
                                    id="secret_key"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="recaptchaForm.secret_key"
                                />
                                <InputError :message="recaptchaForm.errors.secret_key" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox"
                                        v-model="recaptchaForm.is_enabled"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    >
                                    <span class="ml-2 text-sm text-gray-600">Enable reCAPTCHA</span>
                                </label>
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="recaptchaForm.processing">Save</PrimaryButton>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 