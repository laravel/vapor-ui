const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: {
        content: [
            './resources/views/**/*.blade.php',
            './resources/js/**/*.vue',
            './resources/js/**/*.js'
        ],

        options: {
            whitelist: [
                'text-blue-900',
                'text-blue-800',
                'bg-blue-100',
                'text-yellow-900',
                'text-yellow-800',
                'bg-yellow-100',
                'text-red-900',
                'text-red-800',
                'bg-red-100',
                'text-gray-900',
                'text-gray800',
                'bg-gray-100'
            ],
        }
    },
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    variants: {},
    plugins: [require('@tailwindcss/ui')],
};
