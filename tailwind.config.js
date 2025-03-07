import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'gradient-text': 'gradient 6s ease infinite',
                'fade-in-up': 'fadeInUp 0.5s ease-out forwards'
            },
            keyframes: {
                gradient: {
                    '0%, 100%': {
                        'background-position': '0% 50%',
                    },
                    '50%': {
                        'background-position': '100% 50%',
                    },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                }
            }
        },
    },
    plugins: [
        require('daisyui'),
    ],
    daisyui: {
        themes: [{
            mytheme: {
                "primary": "#1e90ff",
                "secondary": "#1e4e5f",
                "accent": "#f3a536",
                "neutral": "#7b7f82",
                "base-100": "#ffffff",
                "info": "#26547C",
                "success": "#06D6A0",
                "warning": "#FFD166",
                "error": "#E43F6F"
            },
        }],
    }
};
