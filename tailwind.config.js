import defaultTheme from "tailwindcss/defaultTheme";
const plugin = require("tailwindcss/plugin");

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.{blade.php,js,vue}",
    "./storage/framework/views/*.php",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],

  theme: {
    container: {
      center: true,
      padding: "1.5rem",
      screens: { "2xl": "1400px" },
    },

    extend: {
 
      fontFamily: {
                playfair: ["Playfair Display", "serif"],
            },
       
   
      fontSize: {
        h1: ["50px", { lineHeight: "1.2", fontWeight: "700" }],
        h2: ["36px", { lineHeight: "1.3", fontWeight: "600" }],
        h3: ["28px", { lineHeight: "1.3", fontWeight: "600" }],
        p: ["18px", { lineHeight: "1.8" }],
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
          from: { height: "0" },
          to: { height: "var(--radix-accordion-content-height)" },
        },
        "accordion-up": {
          from: { height: "var(--radix-accordion-content-height)" },
          to: { height: "0" },
        },
      
      animation: {
        "accordion-down": "accordion-down 0.2s ease-out",
        "accordion-up": "accordion-up 0.2s ease-out",
      },
      fade: {
          "0%": { opacity: 0 },
          "100%": { opacity: 1 },
        },

        slideUp: {
          "0%": { opacity: 0, transform: "translateY(24px)" },
          "100%": { opacity: 1, transform: "translateY(0)" },
        },

        slideDown: {
          "0%": { opacity: 0, transform: "translateY(-24px)" },
          "100%": { opacity: 1, transform: "translateY(0)" },
        },

        slideLeft: {
          "0%": { opacity: 0, transform: "translateX(32px)" },
          "100%": { opacity: 1, transform: "translateX(0)" },
        },

        slideRight: {
          "0%": { opacity: 0, transform: "translateX(-32px)" },
          "100%": { opacity: 1, transform: "translateX(0)" },
        },

        scaleIn: {
          "0%": { opacity: 0, transform: "scale(0.95)" },
          "100%": { opacity: 1, transform: "scale(1)" },
        },

        pop: {
          "0%": { transform: "scale(0.9)", opacity: 0 },
          "80%": { transform: "scale(1.05)", opacity: 1 },
          "100%": { transform: "scale(1)" },
        },
      },
      animation: {
        fade: "fade 0.4s ease-out forwards",
        "slide-up": "slideUp 0.6s ease-out forwards",
        "slide-down": "slideDown 0.6s ease-out forwards",
        "slide-left": "slideLeft 0.6s ease-out forwards",
        "slide-right": "slideRight 0.6s ease-out forwards",
        scale: "scaleIn 0.4s ease-out forwards",
        pop: "pop 0.5s cubic-bezier(.4,0,.2,1) forwards",

        "accordion-down": "accordion-down 0.2s ease-out",
        "accordion-up": "accordion-up 0.2s ease-out",
        "fade-in": "fade-in 0.6s ease-out forwards",
        "slide-up": "slide-up 0.6s ease-out forwards",
        "float": "float 6s ease-in-out infinite",
      },
    },
  },

 
  plugins: [
    plugin(function ({ addComponents }) {
      addComponents({
        ".section-base": {
          paddingTop: "3rem",
          paddingBottom: "3rem",
        },
        "@screen md": {
          ".section-base": { paddingTop: "4rem", paddingBottom: "4rem" },
        },
        "@screen lg": {
          ".section-base": { paddingTop: "4rem", paddingBottom: "4rem" },
        },
        "@screen xl": {
          ".section-base": { paddingTop: "4rem", paddingBottom: "4rem" },
        },
        "@screen 2xl": {
          ".section-base": { paddingTop: "8rem", paddingBottom: "8rem" },
        },

        ".container-base": {
          maxWidth: "1380px",
          marginInline: "auto",
          paddingInline: "1rem",
        },
        "@screen sm": {
          ".container-base": { paddingInline: "1.5rem" },
        },
        "@screen lg": {
          ".container-base": { paddingInline: "2rem" },
        },
      });
    }),
     function ({ addBase, theme }) {
    addBase({
       
      "h1": {
        fontFamily: theme("fontFamily.display"),
        fontWeight: "700",
        fontSize: theme("fontSize.3xl")[0],
        lineHeight: theme("fontSize.3xl")[1].lineHeight,
        marginBottom: theme("spacing.4"),
        textAlign: "center",
      },
      "@screen md": {
        "h1": {
          fontSize: theme("fontSize.4xl")[0],
          lineHeight: theme("fontSize.4xl")[1].lineHeight,
        },
      },
      "@screen lg": {
        "h1": {
          fontSize: theme("fontSize.5xl")[0],
          lineHeight: theme("fontSize.5xl")[1].lineHeight,
        },
      },

      
      "h2": {
        fontFamily: theme("fontFamily.display"),
        fontWeight: "700",
        fontSize: theme("fontSize.2xl")[0],
        lineHeight: theme("fontSize.2xl")[1].lineHeight,
        marginBottom: theme("spacing.4"),
        textAlign: "center",
      },
      "@screen md": {
        "h2": {
          fontSize: theme("fontSize.3xl")[0],
          lineHeight: theme("fontSize.3xl")[1].lineHeight,
        },
      },

      
      "h3": {
        fontFamily: theme("fontFamily.display"),
        fontWeight: "600",
        fontSize: theme("fontSize.xl")[0],
        lineHeight: theme("fontSize.xl")[1].lineHeight,
        marginBottom: theme("spacing.3"),
        
      },
      "@screen md": {
        "h3": {
          fontSize: theme("fontSize.2xl")[0],
          lineHeight: theme("fontSize.2xl")[1].lineHeight,
        },
      },

      
      "h4": {
        fontFamily: theme("fontFamily.display"),
        fontWeight: "600",
        fontSize: theme("fontSize.lg")[0],
        lineHeight: theme("fontSize.lg")[1].lineHeight,
        marginBottom: theme("spacing.2"),
        
      },
      "@screen md": {
        "h4": {
          fontSize: theme("fontSize.xl")[0],
          lineHeight: theme("fontSize.xl")[1].lineHeight,
        },
      },
    });
  },

  
  
  ],
};
