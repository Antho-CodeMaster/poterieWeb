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
        'h-[190px]',
        'object-cover',
        "border-[2px]",
        "border-darkGrey",
        "rounded-[0.5rem]"
    ],

    plugins: [
        forms,
        function ({ addUtilities }) {
            const newUtilities = {

                /* Classe pour les textes */
                //Titre H1
                '.titre1-light': {
                    'line-height': '3rem',
                    'letter-spacing': '0.05rem',
                    'font-weight': '700',
                    'font-size': 'calc(32px + 1.5vw)',
                    'color': '#f4f0ec',
                    'font-family': 'Newsreader',
                },
                '.titre1-dark': {
                    'line-height': '3rem',
                    'letter-spacing': '0.05rem',
                    'font-weight': '700',
                    'font-size': 'calc(32px + 1.5vw)',
                    'color': '#444444',
                    'font-family': 'Newsreader',
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
                },

                //Titre H2
                '.titre3-light': {
                    'line-height': '1.5rem',
                    'letter-spacing': '0.05rem',
                    'font-weight': '500',
                    'font-size': 'calc(20px + 1vw)',
                    'color': '#f4f0ec',
                    'font-family': 'Newsreader',
                },
                '.titre3-dark': {
                    'line-height': '1.5rem',
                    'letter-spacing': '0.05rem',
                    'font-weight': '500',
                    'font-size': 'calc(20px + 1vw)',
                    'color': '#444444',
                    'font-family': 'Newsreader',
                },

                //Titre text Grand
                '.textGrand-light': {
                    'line-height': '1.5rem',
                    'font-size': 'calc(16px + 0.3vw)',
                    'color': '#f4f0ec',
                    'font-family': 'Inter',
                },
                '.textGrand-dark': {
                    'line-height': '1.5rem',
                    'font-size': 'calc(16px + 0.3vw)',
                    'color': '#444444',
                    'font-family': 'Inter',
                },

                //Titre text Moyen
                '.textMoyen-light': {
                    'line-height': '1.25rem',
                    'font-size': 'calc(14px + 0.22vw)',
                    'color': '#f4f0ec',
                    'font-family': 'Inter',
                },
                '.textMoyen-dark': {
                    'line-height': '1.25rem',
                    'font-size': 'calc(14px + 0.22vw)',
                    'color': '#444444',
                    'font-family': 'Inter',
                },
                '.textMoyen': {
                    'line-height': '1.25rem',
                    'font-size': 'calc(14px + 0.22vw)',
                    'font-family': 'Inter',
                },

                //Titre text Petit
                '.textPetit-light': {
                    'line-height': '1rem',
                    'font-size': 'calc(12px + 0.2vw)',
                    'color': '#f4f0ec',
                    'font-family': 'Inter',
                },
                '.textPetit-dark': {
                    'line-height': '1rem',
                    'font-size': 'calc(12px + 0.2vw)',
                    'color': '#444444',
                    'font-family': 'Inter',
                },

                //Titre article gros
                '.articleGrand-light': {
                    'line-height': '1.5rem',
                    'font-size': 'calc(18px + 0.2vw)',
                    'color': '#f4f0ec',
                    'font-weight': '700',
                    'font-family': 'Inter',
                    'text-overflow': 'ellipsis',
                    'overflow': 'hidden',
                    'whitespace': 'nowrap'
                },
                '.articleGrand-dark': {
                    'line-height': '2rem',
                    'font-size': 'calc(18px + 0.2vw)',
                    'font-weight': '700',
                    'color': '#444444',
                    'font-family': 'Inter',
                    'text-overflow': 'ellipsis',
                    'overflow': 'hidden',
                    'whitespace': 'nowrap'
                },

                //Titre article petit
                '.articlePetit-light': {
                    'line-height': '1.5rem',
                    'font-size': 'calc(14px + 0.2vw)',
                    'color': '#f4f0ec',
                    'font-weight': '600',
                    'font-family': 'Inter',
                    'text-overflow': 'ellipsis',
                    'overflow': 'hidden',
                    'whitespace': 'nowrap'
                },
                '.articlePetit-dark': {
                    'line-height': '1.5rem',
                    'font-size': 'calc(14px + 0.2vw)',
                    'color': '#444444',
                    'font-weight': '600',
                    'font-family': 'Inter',
                    'text-overflow': 'ellipsis',
                    'overflow': 'hidden',
                    'whitespace': 'nowrap'
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
                    'font-size': 'calc(14px + 0.5vw)',
                    'color': '#f4f0ec',
                    'font-weight': '500',
                    'font-family': 'Inter',
                },
                '.textNavigation-dark': {
                    'line-height': '1.5rem',
                    'font-size': 'calc(14px + 0.5vw)',
                    'color': '#444444',
                    'font-weight': '500',
                    'font-family': 'Inter',
                },

                /* Margin */
                // Sections
                '.m-section': {
                    'margin': 'calc(8px + 0.2vw) calc(12px + 0.3vw)',
                },

                '.m-sectionX': {
                    'margin-right': 'calc(12px + 0.3vw) ',
                    'margin-left': 'calc(12px + 0.3vw) ',
                },

                '.m-sectionY': {
                    'margin-top': 'calc(8px + 0.2vw) ',
                    'margin-bottom': 'calc(8px + 0.2vw) ',
                },

                '.p-sectionBottom': {
                    'padding-bottom': 'calc(2px + 0.4vw)',
                },

                '.p-sectionTop': {
                    'padding-top': 'calc(2px + 0.4vw)',
                },


                '.p-sectionX': {
                    'padding-right': 'calc(2px + 0.4vw) ',
                    'padding-left': 'calc(2px + 0.4vw) ',
                },

                '.p-sectionY': {
                    'padding-top': 'calc(2px + 0.4vw)',
                    'padding-bottom': 'calc(2px + 0.4vw)',
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

                '.gap-inputXXL': {
                    'gap': 'calc(6px + 0.8vw)',
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
                    'padding': 'calc(8px + 0.5vw) 0.5rem',
                },

                // Titre
                '.m-titreY': {
                    'margin-top': 'calc(2px + 0.2vw) ',
                    'margin-bottom': 'calc(2px + 0.2vw) ',
                },

                // Autres
                '.m-submit': {
                    'margin-top': 'calc(8px + 1vw)',
                },

                /* Couleurs */
                // SideBar
                '.color-sideBar': {
                    'background-color': '#f4f0ec',
                },

                '.color-sideBar-hover:hover': {
                    'background-color': '#ebe3dc',
                },

                //Message erreur
                '.color-borderError': {
                    'border-color': '#E6AF00',
                },
            }

            addUtilities(newUtilities)
        }
    ]
};
