<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const activeSection = ref('smtp');

const smtpForm = useForm({
    host: '',
    port: '',
    username: '',
    password: '',
    encryption: 'tls',
    from_address: '',
    from_name: '',
});

const recaptchaForm = useForm({
    site_key: '',
    secret_key: '',
    enabled: false,
});

const getSettings = async () => {
    const response = await axios.get(route('admin.settings.index'));
    const settings = response.data;
    
    // Fill SMTP settings
    smtpForm.host = settings.smtp?.host || '';
    smtpForm.port = settings.smtp?.port || '';
    smtpForm.username = settings.smtp?.username || '';
    smtpForm.encryption = settings.smtp?.encryption || 'tls';
    smtpForm.from_address = settings.smtp?.from_address || '';
    smtpForm.from_name = settings.smtp?.from_name || '';
    
    // Fill reCAPTCHA settings
    recaptchaForm.site_key = settings.recaptcha?.site_key || '';
    recaptchaForm.secret_key = settings.recaptcha?.secret_key || '';
    recaptchaForm.enabled = settings.recaptcha?.enabled || false;
};

const saveSmtpSettings = () => {
    smtpForm.post(route('admin.settings.smtp.update'), {
        preserveScroll: true,
        onSuccess: () => {
            alert('SMTP settings saved successfully!');
        },
    });
};

const saveRecaptchaSettings = () => {
    recaptchaForm.post(route('admin.settings.recaptcha.update'), {
        preserveScroll: true,
        onSuccess: () => {
            alert('reCAPTCHA settings saved successfully!');
        },
    });
};

const testSmtpConnection = async () => {
    try {
        await axios.post(route('admin.settings.smtp.test'));
        alert('SMTP connection test successful!');
    } catch (error) {
        alert('SMTP connection test failed: ' + error.response.data.message);
    }
};

onMounted(() => {
    getSettings();
});
</script>

<template>
    <section class="p-4 sm:p-8">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Configuration Settings</h2>
            <p class="mt-1 text-sm text-gray-600">
                Manage application settings such as SMTP and reCAPTCHA configuration.
            </p>
        </header>

        <div class="mt-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button
                        @click="activeSection = 'smtp'"
                        :class="[
                            'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm',
                            activeSection === 'smtp'
                                ? 'border-orange-500 text-orange-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                        ]"
                    >
                        SMTP Settings
                    </button>
                    <button
                        @click="activeSection = 'recaptcha'"
                        :class="[
                            'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm',
                            activeSection === 'recaptcha'
                                ? 'border-orange-500 text-orange-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                        ]"
                    >
                        reCAPTCHA Settings
                    </button>
                </nav>
            </div>

            <div v-if="activeSection === 'smtp'" class="mt-6 space-y-6">
                <form @submit.prevent="saveSmtpSettings">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <InputLabel for="smtp_host" value="SMTP Host" />
                            <TextInput
                                id="smtp_host"
                                v-model="smtpForm.host"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="smtp.example.com"
                            />
                            <InputError :message="smtpForm.errors.host" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="smtp_port" value="SMTP Port" />
                            <TextInput
                                id="smtp_port"
                                v-model="smtpForm.port"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="587"
                            />
                            <InputError :message="smtpForm.errors.port" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="smtp_username" value="SMTP Username" />
                            <TextInput
                                id="smtp_username"
                                v-model="smtpForm.username"
                                type="text"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="smtpForm.errors.username" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="smtp_password" value="SMTP Password" />
                            <TextInput
                                id="smtp_password"
                                v-model="smtpForm.password"
                                type="password"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="smtpForm.errors.password" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="smtp_encryption" value="Encryption" />
                            <select
                                id="smtp_encryption"
                                v-model="smtpForm.encryption"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            >
                                <option value="tls">TLS</option>
                                <option value="ssl">SSL</option>
                                <option value="none">None</option>
                            </select>
                            <InputError :message="smtpForm.errors.encryption" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="from_address" value="From Address" />
                            <TextInput
                                id="from_address"
                                v-model="smtpForm.from_address"
                                type="email"
                                class="mt-1 block w-full"
                                placeholder="noreply@example.com"
                            />
                            <InputError :message="smtpForm.errors.from_address" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="from_name" value="From Name" />
                            <TextInput
                                id="from_name"
                                v-model="smtpForm.from_name"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Your Application"
                            />
                            <InputError :message="smtpForm.errors.from_name" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-4">
                        <PrimaryButton :disabled="smtpForm.processing">Save Settings</PrimaryButton>
                        <button
                            type="button"
                            @click="testSmtpConnection"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            Test Connection
                        </button>
                    </div>
                </form>
            </div>

            <div v-if="activeSection === 'recaptcha'" class="mt-6 space-y-6">
                <form @submit.prevent="saveRecaptchaSettings">
                    <div class="space-y-6">
                        <div>
                            <InputLabel for="site_key" value="Site Key" />
                            <TextInput
                                id="site_key"
                                v-model="recaptchaForm.site_key"
                                type="text"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="recaptchaForm.errors.site_key" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="secret_key" value="Secret Key" />
                            <TextInput
                                id="secret_key"
                                v-model="recaptchaForm.secret_key"
                                type="password"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="recaptchaForm.errors.secret_key" class="mt-2" />
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input
                                    id="enabled"
                                    v-model="recaptchaForm.enabled"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                                />
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="enabled" class="font-medium text-gray-700">Enable reCAPTCHA</label>
                                <p class="text-gray-500">Enable reCAPTCHA protection for forms</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-4">
                        <PrimaryButton :disabled="recaptchaForm.processing">Save Settings</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template> 