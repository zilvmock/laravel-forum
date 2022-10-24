const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ["Nunito", ...defaultTheme.fontFamily.sans],
        ubuntu: "Ubuntu",
        gemunu: "Gemunu Libre",
      },
      fontSize: {
        md: "1rem",
        "2xl": "1.563rem",
        "3xl": "1.953rem",
        "4xl": "2.441rem",
        "5xl": "3.052rem",
      },
      colors: {
        darkslatedimgray: "rgb(51,51,51)",
        darkslategray: "#3b3f41",
        dimgray: "#4f585c",
      },
    },
    screens: {
      xxs: "410px",
      xs: "475px",
      sm: "640px",
      md: "768px",
      lg: "1024px",
      xl: "1280px",
      "2xl": "1536px",
    },
  },

  daisyui: {
    darkTheme: "business",
  },

  plugins: [require("@tailwindcss/forms"), require("daisyui")],
};
