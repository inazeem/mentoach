<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    action: {
        type: String,
        required: true
    }
});

const emit = defineEmits(['update:token']);
const token = ref(null);

const executeReCaptcha = async () => {
    try {
        token.value = await window.grecaptcha.execute(import.meta.env.VITE_RECAPTCHA_SITE_KEY, { action: props.action });
        emit('update:token', token.value);
    } catch (error) {
        console.error('ReCaptcha error:', error);
    }
};

onMounted(() => {
    // Load reCAPTCHA if not already loaded
    if (!window.grecaptcha) {
        const script = document.createElement('script');
        script.src = `https://www.google.com/recaptcha/api.js?render=${import.meta.env.VITE_RECAPTCHA_SITE_KEY}`;
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);

        script.onload = () => {
            window.grecaptcha.ready(() => {
                executeReCaptcha();
            });
        };
    } else {
        window.grecaptcha.ready(() => {
            executeReCaptcha();
        });
    }
});
</script>

<template>
    <div class="g-recaptcha" data-size="invisible"></div>
</template> 