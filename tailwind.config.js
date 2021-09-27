const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    darkMode: 'media',
    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
