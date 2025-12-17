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
      /* -------------------- FONTS -------------------- */
      fontFamily: {
                playfair: ["Playfair Display", "serif"],
            },
       
      /* -------------------- FONT SIZES -------------------- */
      fontSize: {
        h1: ["50px", { lineHeight: "1.2", fontWeight: "700" }],
        h2: ["36px", { lineHeight: "1.3", fontWeight: "600" }],
        h3: ["28px", { lineHeight: "1.3", fontWeight: "600" }],
        p: ["18px", { lineHeight: "1.8" }],
      },

      /* -------------------- COLORS (CSS Variables) -------------------- */
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

      /* -------------------- BORDER RADIUS -------------------- */
      borderRadius: {
        lg: "var(--radius)",
        md: "calc(var(--radius) - 2px)",
        sm: "calc(var(--radius) - 4px)",
      },

      /* -------------------- SHADOWS -------------------- */
      boxShadow: {
        soft: "var(--shadow-soft)",
        medium: "var(--shadow-medium)",
        strong: "var(--shadow-strong)",
      },

      /* -------------------- ANIMATIONS -------------------- */
      keyframes: {
        "accordion-down": {
          from: { height: "0" },
          to: { height: "var(--radix-accordion-content-height)" },
        },
        "accordion-up": {
          from: { height: "var(--radix-accordion-content-height)" },
          to: { height: "0" },
        },
      },
      animation: {
        "accordion-down": "accordion-down 0.2s ease-out",
        "accordion-up": "accordion-up 0.2s ease-out",
      },
    },
  },

  /* -------------------- PLUGINS -------------------- */
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
          ".section-base": { paddingTop: "6rem", paddingBottom: "6rem" },
        },
        "@screen xl": {
          ".section-base": { paddingTop: "7rem", paddingBottom: "7rem" },
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
      /* -------------------------
         H1 (Main Page Title)
      ------------------------- */
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

      /* -------------------------
         H2 (Section Title)
      ------------------------- */
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

      /* -------------------------
         H3 (Sub-section Heading)
      ------------------------- */
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

      /* -------------------------
         H4 (Small Heading)
      ------------------------- */
      "h4": {
        fontFamily: theme("fontFamily.display"),
        fontWeight: "600",
        fontSize: theme("fontSize.lg")[0],
        lineHeight: theme("fontSize.lg")[1].lineHeight,
        marginBottom: theme("spacing.2"),
        textAlign: "center",
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
