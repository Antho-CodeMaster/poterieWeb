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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                titre: ['"Newsreader"'],
                small: ['"Arial"']
            },
            fontSize: {
                titre: ['36px', {
                  lineHeight: '2rem',
                  letterSpacing: '0.2em',
                  fontWeight: 'bold',
                }],

                footer: ['12px', {
                    lineHeight: '1rem',
                    letterSpacing: '0em',
                    fontWeight: 'medium',
                  }],
            },
            colors: {
                'darkGrey': '#444444',
                'vert' : '#009b4d',
                'beige' : '#f4f0ec',
                'rouge': '#ff0000',
            },
            height: {
                'nav': '48px',
            },
            borderWidth: {
                DEFAULT: '2px',
            },
            borderRadius: {
                DEFAULT: '28px',
              }
        },
    },

    plugins: [forms],
};
