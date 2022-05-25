const defaultTheme = require('tailwindcss/defaultTheme');
const plugin = require('tailwindcss/plugin');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/tw-elements/dist/js/**/*.js'
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
                poppins: ['Poppins', 'sans-serif']
            },
            // colors: THEME_COLORS,
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
        require("daisyui"),
        require('@tailwindcss/line-clamp')
    ],
    daisyui: {
        // styled: true,
        // base: false,
        // utils: false,
        themes: [
            {
                mytheme: {
                    "primary": "#b80000",
                    "secondary": "#0D0D0D",
                    "accent": "#37CDBE",
                    "neutral": "#0D0D0D",
                    "base-100": "#FFFFFF",
                    "info": "#3ABFF8",
                    "success": "#198754",
                    "warning": "#FBBD23",
                    "error": "#F87272",
                },
            },
            "dark",
        ],
        darkTheme: "dark",
    },
};
