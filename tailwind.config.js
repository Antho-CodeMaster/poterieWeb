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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                titre: ['"Newsreader"'],
                small: ['"Arial"']
            },

            fontSize: {
                titre: ['36px', {
                    lineHeight: '2rem',
                    letterSpacing: '0.2em',
                    fontWeight: '500',
                }],

                titreSection: ['30px', {
                    lineHeight: '2rem',
                    letterSpacing: '0.1em',
                    fontWeight: '500',
                }],

                footer: ['12px', {
                    lineHeight: '1rem',
                    letterSpacing: '0em',
                    fontWeight: 'medium',
                }],

                reseaux: ['24px', {
                    lineHeight: '2rem',
                    letterSpacing: '0.0em',
                    fontWeight: 'bold',
                }],

                article: ['18px', {
                    lineHeight: '1rem',
                    letterSpacing: '0.0em',
                    fontWeight: 'bold',
                }],

                smallArticle: ['14px', {
                    lineHeight: '1rem',
                    letterSpacing: '0.0em',
                    fontWeight: 'bold',
                }],

            },
            colors: {
                'darkGrey': '#444444',
                'vert': '#009b4d',
                'beige': '#f4f0ec',
                'red': '#ff0000'
            },

            height: {
                'nav': '48px',
            },

            borderWidth: {
                DEFAULT: '2px',
            },

            borderRadius: {
                DEFAULT: '28px',
            },

            keyframes: {
                scrollText: {
                  '0%': { transform: 'translateX(100%)' },
                  '100%': { transform: 'translateX(-100%)' },
                },
            },

            animation: {
                scrollText: 'scrollText 10s linear infinite',
            },

        },


    },

    safelist: [
        'w-[100px]',
        'h-[96px]',
        'object-cover',
        "border-[2px]",
        "border-darkGrey",
        "rounded-[0.375rem]"
    ],

    plugins: [forms],
};
