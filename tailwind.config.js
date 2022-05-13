const defaultTheme = require('tailwindcss/defaultTheme');
const plugin = require('tailwindcss/plugin');

const THEME_COLORS = {
    primary: "#b80000", // Can always use CSS variables too e.g. "var(--color-primary)",
    secondary: "#0D0D0D",
    brand: "#243c5a",
    neutral: "#0D0D0D",
    info: "#3ABFF8",
    success: "#198754",
    warning: "#FBBD23",
    error: "#F87272"
};



module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/tw-elements/dist/js/**/*.js'
    ],
    theme: {
        colors: THEME_COLORS,
        extend: {
            fontFamily: {
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
                poppins: ['Poppins', 'sans-serif']
            },
            // color: {
            //     primary: "#b80000", // Can always use CSS variables too e.g. "var(--color-primary)",
            //     secondary: "#0D0D0D",
            //     brand: "#243c5a",
            //     neutral: "#0D0D0D",
            //     info: "#3ABFF8",
            //     success: "#198754",
            //     warning: "#FBBD23",
            //     error: "#F87272",
            // },
        },
    },
    darkMode: 'class',
    plugins: [
        require('@tailwindcss/forms'),
        require('tw-elements/dist/plugin'),
        // require("daisyui"),
        plugin(function({ addUtilities, theme }) {
            const newUtilities = {
                '.custom-scrollbar': {
                    '.custom-scrollbar::-webkit-scrollbar': { width: '6px' },
                    '.custom-scrollbar::-webkit-scrollbar-track': { background: theme('bg-secondary')},
                    '.custom-scrollbar::-webkit-scrollbar-thumb': { background: '#888' },
                    '.custom-scrollbar::-webkit-scrollbar-thumb:hover': {background: '#555'},
                }
            }

            addUtilities(newUtilities, ['responsive', 'hover'])
        }),
        require('@tailwindcss/line-clamp'),
        require('tailwindcss-css-variables-palette-plugin')({
            colors: THEME_COLORS,
        }),
    ]
};
