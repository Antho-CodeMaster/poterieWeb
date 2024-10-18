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
                'lightGrey': '#c7c7c7',
                'hoverGrey': '#A3A3A3',
                'vert': '#009b4d',
                'lightVert': '#00CE66',
                'rouge': '#ff0000',
                'jauneWarning': '#E6AF00',
                'vertSucces': "#3c9035",
                'rougeFail': "#e60000"
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
        "rounded-[0.375rem]"
    ],

    plugins: [
        forms,
        function ({ addUtilities }) {
            const newUtilities = {

                /* Classe pour les textes */
                //Titre H1
                '.titre1-light': {
                    'line-height': '4rem',
                    'letter-spacing': '0.05rem',
                    'font-weight': '700',
                    'font-size': 'calc(32px + 1.5vw)',
                    'color': '#f4f0ec',
                    'font-family': 'Newsreader',
                    'margin-top': "4px",
                    'margin-bottom': "8px",
                },
                '.titre1-dark': {
                    'line-height': '4rem',
                    'letter-spacing': '0.05rem',
                    'font-weight': '700',
                    'font-size': 'calc(32px + 1.5vw)',
                    'color': '#444444',
                    'font-family': 'Newsreader',
                    'margin-top': "4px",
                    'margin-bottom': "8px",
                },

                //Titre H2
                '.titre2-light': {
                    'line-height': '2rem',
                    'letter-spacing': '0.05rem',
                    'font-weight': '500',
                    'font-size': 'calc(26px + 1vw)',
                    'color': '#f4f0ec',
                    'font-family': 'Newsreader',
                },
                '.titre2-dark': {
                    'line-height': '2rem',
                    'letter-spacing': '0.05rem',
                    'font-weight': '500',
                    'font-size': 'calc(26px + 1vw)',
                    'color': '#444444',
                    'font-family': 'Newsreader',
                    'margin-top': "4px",
                    'margin-bottom': "8px",
                },

                //Titre text Grand
                '.textGrand-light': {
                    'line-height': '1rem',
                    'font-size': 'calc(16px + 0.3vw)',
                    'color': '#f4f0ec',
                    'font-family': 'Inter',
                    'margin': '0px',
                    'padding': '0px'
                },
                '.textGrand-dark': {
                    'line-height': '1rem',
                    'font-size': 'calc(16px + 0.3vw)',
                    'color': '#444444',
                    'font-family': 'Inter',
                    'margin': '0px',
                    'padding': '0px'
                },


                //Titre text Petit
                '.textPetit-light': {
                    'line-height': '1rem',
                    'font-size': 'calc(12px + 0.2vw)',
                    'color': '#f4f0ec',
                    'font-family': 'Inter',
                    'margin': '0px',
                    'padding': '0px'
                },
                '.textPetit-dark': {
                    'line-height': '1rem',
                    'font-size': 'calc(12px + 0.2vw)',
                    'color': '#444444',
                    'font-family': 'Inter',
                    'margin': '0px',
                    'padding': '0px'
                },

                //Titre article gros
                '.articleGrand-light': {
                    'line-height': '1rem',
                    'font-size': 'calc(16px + 0.3vw)',
                    'color': '#f4f0ec',
                    'font-weight': '500',
                    'font-family': 'Inter',
                    'margin-top': "2px",
                    'margin-bottom': "2px",
                    'padding': '0px'
                },
                '.articleGrand-dark': {
                    'line-height': '1rem',
                    'font-size': 'calc(16px + 0.3vw)',
                    'font-weight': '500',
                    'color': '#444444',
                    'font-family': 'Inter',
                    'margin-top': "2px",
                    'margin-bottom': "2px",
                    'padding': '0px'
                },


                //Titre article petit
                '.articlePetit-light': {
                    'line-height': '1rem',
                    'font-size': 'calc(14px + 0.2vw)',
                    'color': '#f4f0ec',
                    'font-weight': '500',
                    'font-family': 'Inter',
                    'margin-top': "2px",
                    'margin-bottom': "2px",
                    'padding': '0px'
                },
                '.articlePetit-dark': {
                    'line-height': '1rem',
                    'font-size': 'calc(14px + 0.2vw)',
                    'color': '#444444',
                    'font-weight': '500',
                    'font-family': 'Inter',
                    'margin-top': "2px",
                    'margin-bottom': "2px",
                    'padding': '0px'
                },

                //Text footer
                '.textFooter-light': {
                    'line-height': '1rem',
                    'font-size': 'calc(11px + 0.2vw)',
                    'color': '#f4f0ec',
                    'font-weight': '300',
                    'font-family': 'Inter',
                    'margin-top': "2px",
                    'margin-bottom': "2px",
                    'padding': '2px'
                },
                '.textFooter-dark': {
                    'line-height': '1rem',
                    'font-size': 'calc(11px + 0.2vw)',
                    'color': '#444444',
                    'font-weight': '300',
                    'font-family': 'Inter',
                    'margin-top': "2px",
                    'margin-bottom': "2px",
                    'padding': '2px'
                },

                //Text de navigation SideMenu ou navBar
                '.textNavigation-light': {
                    'line-height': '1.5rem',
                    'font-size': 'calc(16px + 0.3vw)',
                    'color': '#f4f0ec',
                    'font-weight': '500',
                    'font-family': 'Inter',
                },
                '.textNavigation-dark': {
                    'line-height': '1.5rem',
                    'font-size': 'calc(16px + 0.3vw)',
                    'color': '#444444',
                    'font-weight': '500',
                    'font-family': 'Inter',
                },

                /* Margin */
                // Sections
                '.m-section': {
                    'margin': 'calc(8px + 0.2vw) calc(12px + 0.3vw)',
                },

                '.p-sectionBottom': {
                    'padding-bottom': 'calc(3px + 0.5vw)',
                },

                '.p-sectionX': {
                    'padding-right': 'calc(3px + 0.5vw) ',
                    'padding-left': 'calc(3px + 0.5vw) ',
                },

                '.p-sectionY': {
                    'padding-top': 'calc(3px + 0.5vw)',
                    'padding-bottom': 'calc(3px + 0.5vw)',
                },


                // Articles
                '.m-article': {
                    'margin': 'calc(12px + 0.2vw) calc(6px + 0.9vw)',
                },

                // Collections
                '.m-collection': {
                    'margin': 'calc(8px + 1.5vw) 0px',
                },

                // Forms
                '.m-sectionFormY': {
                    'margin-bottom': 'calc(6px + 1vw)',
                },

                '.m-sectionFormX': {
                    'margin-right': 'calc(6px + 1vw)',
                },

                '.gap-input': {
                    'gap': 'calc(2px + 0.5vw)',
                },

                // SideBar
                '.m-sidebar': {
                    'margin': 'calc(4px + 1.5vw) 0px',
                },

                '.p-sidebar': {
                    'padding': 'calc(4px + 0.5vw) 0.5rem',
                },

                '.p-sidebar-MD': {
                    'padding': 'calc(7px + 0.45vw) 0.5rem',
                },

                '.p-sidebarNav': {
                    'padding': 'calc(2px + 0.5vw) 0.5rem',
                },

                // Autres
                '.m-submit': {
                    'margin-top': 'calc(8px + 1vw)',
                },

                /* Couleurs */
            }

            addUtilities(newUtilities)
        }
    ]
};
