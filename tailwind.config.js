import defaultTheme from 'tailwindcss/defaultTheme';
const plugin = require('tailwindcss/plugin')


/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        container: {
            center: true,
            padding: "2rem",
            screens: {
                "2xl": "1400px",
            },
        },
        extend: {
            fontFamily: {
                sans: ['Bellota Text', 'Bellota Text', 'Red Hat Display'],
                heading: ["Bellota Text", "normal", "sans-serif"],
                body: ["Red Hat Display", "sans-serif"],
            },
            fontSize: {
                        h1: ["50px", { lineHeight: "1.2", fontWeight: "700" }],
                        h2: ["36px", { lineHeight: "1.3", fontWeight: "600" }],
                        h3: ["28px", { lineHeight: "1.3", fontWeight: "600" }],
                        p:  ["16px", { lineHeight: "1.6" }],
                    },
            colors: {
                border: "hsl(var(--border))",
                input: "hsl(var(--input))",
                ring: "hsl(var(--ring))",
                background: "hsl(var(--background))",
                foreground: "hsl(var(--foreground))",
                primary: {
                    DEFAULT: "hsl(var(--primary))",
                    foreground: "hsl(var(--primary-foreground))",
                },
                secondary: {
                    DEFAULT: "hsl(var(--secondary))",
                    foreground: "hsl(var(--secondary-foreground))",
                },
                destructive: {
                    DEFAULT: "hsl(var(--destructive))",
                    foreground: "hsl(var(--destructive-foreground))",
                },
                muted: {
                    DEFAULT: "hsl(var(--muted))",
                    foreground: "hsl(var(--muted-foreground))",
                },
                accent: {
                    DEFAULT: "hsl(var(--accent))",
                    foreground: "hsl(var(--accent-foreground))",
                },
                popover: {
                    DEFAULT: "hsl(var(--popover))",
                    foreground: "hsl(var(--popover-foreground))",
                },
                card: {
                    DEFAULT: "hsl(var(--card))",
                    foreground: "hsl(var(--card-foreground))",
                },
                sidebar: {
                    DEFAULT: "hsl(var(--sidebar-background))",
                    foreground: "hsl(var(--sidebar-foreground))",
                    primary: "hsl(var(--sidebar-primary))",
                    "primary-foreground": "hsl(var(--sidebar-primary-foreground))",
                    accent: "hsl(var(--sidebar-accent))",
                    "accent-foreground": "hsl(var(--sidebar-accent-foreground))",
                    border: "hsl(var(--sidebar-border))",
                    ring: "hsl(var(--sidebar-ring))",
                },
            },
            borderRadius: {
                lg: "var(--radius)",
                md: "calc(var(--radius) - 2px)",
                sm: "calc(var(--radius) - 4px)",
            },
            boxShadow: {
                soft: "var(--shadow-soft)",
                medium: "var(--shadow-medium)",
                strong: "var(--shadow-strong)",
            },
            keyframes: {
                "accordion-down": {
                    from: {
                        height: "0",
                    },
                    to: {
                        height: "var(--radix-accordion-content-height)",
                    },
                },
                "accordion-up": {
                    from: {
                        height: "var(--radix-accordion-content-height)",
                    },
                    to: {
                        height: "0",
                    },
                },
            },
            animation: {
                "accordion-down": "accordion-down 0.2s ease-out",
                "accordion-up": "accordion-up 0.2s ease-out",
            },
        },
    },
    plugins: [
        plugin(function({ addUtilities }) {
            addUtilities({
                '.section-base': {
                    paddingTop: '3rem',      // 12
                    paddingBottom: '3rem',
                },
                '@screen md': {
                    '.section-base': {
                        paddingTop: '4rem', // 16
                        paddingBottom: '4rem',
                    },
                },
                '@screen lg': {
                    '.section-base': {
                        paddingTop: '6rem', // 24
                        paddingBottom: '6rem',
                    },
                },
                '@screen xl': {
                    '.section-base': {
                        paddingTop: '7rem', // 28
                        paddingBottom: '7rem',
                    },
                },
                '@screen 2xl': {
                    '.section-base': {
                        paddingTop: '8rem', // 32
                        paddingBottom: '8rem',
                    },
                },

                // Container utility inside config
                '.container-base': {
                    maxWidth: '1380px',
                    marginLeft: 'auto',
                    marginRight: 'auto',
                    paddingLeft: '1rem',
                    paddingRight: '1rem',
                },
                '@screen sm': {
                    '.container-base': {
                        paddingLeft: '1.5rem',
                        paddingRight: '1.5rem',
                    },
                },
                '@screen lg': {
                    '.container-base': {
                        paddingLeft: '2rem',
                        paddingRight: '2rem',
                    },
                },
            })
        })
    ],
};

 