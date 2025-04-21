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

// Debug: Log all available environment variables
console.log('Available env variables:', import.meta.env);
console.log('VITE_RECAPTCHA_SITE_KEY value:', import.meta.env.VITE_RECAPTCHA_SITE_KEY);

const executeReCaptcha = async () => {
    try {
        // Debug: Log the site key value
        console.log('Checking site key:', import.meta.env.VITE_RECAPTCHA_SITE_KEY);
        
        if (!import.meta.env.VITE_RECAPTCHA_SITE_KEY) {
            console.error('ReCaptcha site key is missing. Please add VITE_RECAPTCHA_SITE_KEY to your .env file');
            return;
        }

        if (!window.grecaptcha) {
            console.error('ReCaptcha not loaded');
            setTimeout(executeReCaptcha, 1000); // Retry after 1 second
            return;
        }
        
        token.value = await window.grecaptcha.execute(import.meta.env.VITE_RECAPTCHA_SITE_KEY, { action: props.action });
        emit('update:token', token.value);
        
        // Refresh token every 2 minutes
        setTimeout(executeReCaptcha, 120000);
    } catch (error) {
        console.error('ReCaptcha error:', error);
        setTimeout(executeReCaptcha, 1000); // Retry after 1 second on error
    }
};

onMounted(() => {
    // Debug: Log the site key value again on mount
    console.log('Mounting with site key:', import.meta.env.VITE_RECAPTCHA_SITE_KEY);
    
    // Validate reCAPTCHA site key
    if (!import.meta.env.VITE_RECAPTCHA_SITE_KEY) {
        console.error('ReCaptcha site key is missing. Please add VITE_RECAPTCHA_SITE_KEY to your .env file');
        return;
    }

    // Load reCAPTCHA if not already loaded
    if (!window.grecaptcha) {
        const script = document.createElement('script');
        script.src = `https://www.google.com/recaptcha/api.js?render=${import.meta.env.VITE_RECAPTCHA_SITE_KEY}`;
        script.async = true;
        script.defer = true;
        
        script.onload = () => {
            window.grecaptcha.ready(() => {
                executeReCaptcha();
            });
        };
        
        script.onerror = (error) => {
            console.error('Failed to load ReCaptcha script:', error);
            setTimeout(() => {
                // Remove failed script and try again
                script.remove();
                onMounted();
            }, 2000);
        };
        
        document.head.appendChild(script);
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