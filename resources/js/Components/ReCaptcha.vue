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

// Try to get the site key from different possible sources
const getSiteKey = () => {
    // First priority: window object from blade template
    if (window.RECAPTCHA_SITE_KEY && window.RECAPTCHA_SITE_KEY !== '') {
        return window.RECAPTCHA_SITE_KEY;
    }
    
    // Second priority: Vite env
    if (import.meta.env.VITE_RECAPTCHA_SITE_KEY) {
        return import.meta.env.VITE_RECAPTCHA_SITE_KEY;
    }
    
    // Third priority: global state in production
    if (window.__INITIAL_STATE__?.recaptchaSiteKey) {
        return window.__INITIAL_STATE__.recaptchaSiteKey;
    }
    
    console.error('ReCaptcha site key is missing. Please ensure RECAPTCHA_SITE_KEY is set in your environment');
    return null;
};

const executeReCaptcha = async () => {
    try {
        const siteKey = getSiteKey();
        if (!siteKey) {
            console.error('Unable to find ReCaptcha site key. Please check your environment configuration.');
            return;
        }

        if (!window.grecaptcha) {
            console.error('ReCaptcha not loaded');
            setTimeout(executeReCaptcha, 1000);
            return;
        }
        
        token.value = await window.grecaptcha.execute(siteKey, { action: props.action });
        emit('update:token', token.value);
        
        // Refresh token every 2 minutes
        setTimeout(executeReCaptcha, 120000);
    } catch (error) {
        console.error('ReCaptcha error:', error);
        setTimeout(executeReCaptcha, 1000);
    }
};

onMounted(() => {
    const siteKey = getSiteKey();
    if (!siteKey) {
        return;
    }

    // Load reCAPTCHA if not already loaded
    if (!window.grecaptcha) {
        const script = document.createElement('script');
        script.src = `https://www.google.com/recaptcha/api.js?render=${siteKey}`;
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