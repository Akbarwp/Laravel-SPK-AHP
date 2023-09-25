const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "class",
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        themeVariants: ['dark'],
        extend: {
            fontFamily: {
                lato: ["Lato"],
                workSans: ["Work Sans"],
            },
            colors: {
                //
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require("daisyui"),
        require('tailwind-scrollbar')({ nocompatible: true }),
    ],
};
