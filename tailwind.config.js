let buttom;
/** @type {import('tailwindcss').Config} */
export default {
  content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue"
  ],
  theme: {
    extend: {
        color: {
            back: "linear-gradient(to bottom, blue, pink)",
            errortext: "#D63301",
            errorbg: "#FFCCBA",
        },
        fontFamily: {
            montserrat: "font-family: montserrat"
        },
        margin: {
            35: "35%",
            28: "28%"
        },
        width: {
            message: "4/6",
        },
        spacing: {
            add: "20%"
        }
    },
  },
  plugins: [],
}

