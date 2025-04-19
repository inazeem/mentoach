const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    800: '#0A2647',
                    900: '#051C38',
                },
                orange: {
                    500: '#E48F1B',
                    600: '#D17F0F',
                    700: '#B86E0D',
                }
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
