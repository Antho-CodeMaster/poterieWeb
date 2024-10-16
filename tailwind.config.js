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
                'beigeFoncé': '#d8c9bb',
                'hoverBeige': '#ebe3dc',
                'lightGrey' : '#c7c7c7',
                'hoverGrey' : '#A3A3A3',
                'vert' : '#009b4d',
                'lightVert' : '#00CE66',
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
            },
        },


    },

    safelist: [
        'w-[100px]',
        'h-[96px]',
        'object-cover',
        "border-[2px]",
        "border-darkGrey",
        "rounded-[0.375rem]",
        {
            pattern: /bg-+/
        }
    ],

    plugins: [forms],
};
