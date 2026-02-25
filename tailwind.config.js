import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Exo 2"', 'sans-serif', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#F0FDF4',
                    100: '#DCFCE7',
                    200: '#BBF7D0',
                    300: '#86EFAC',
                    400: '#4ADE80',
                    500: '#22C55E',  // Soft Green (Tailwind Green-500) - Clean
                    600: '#16A34A',
                    700: '#15803D',  // Emerald-ish
                    800: '#166534',
                    900: '#14532D',
                    950: '#052e16',  // Deep Dark Islamic Green
                },
                secondary: {
                    50: '#FDFBF7',
                    100: '#FDF6E3', // Sand
                    200: '#FDE68A',
                    300: '#FCD34D',
                    400: '#FBBF24',
                    500: '#D97706', // Gold/Bronze
                    600: '#B45309',
                    700: '#92400E',
                    800: '#78350F',
                    900: '#451A03',
                    950: '#2A1002',
                },
            },
        },
    },

    plugins: [forms],
};
