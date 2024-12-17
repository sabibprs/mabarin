/** @type {import('tailwindcss').Config} */
import { colors as defaultColors } from 'tailwindcss/defaultTheme';

const colors = {
  'elephant': {
    50: '#f1f7fa',
    100: '#dcebf1',
    200: '#bdd9e4',
    300: '#90bdd0',
    400: '#5b98b5',
    500: '#407c9a',
    600: '#386682',
    700: '#32546c',
    800: '#30485a',
    900: '#243340',
    950: '#23323d',
  },
  'vulcan': {
    50: '#f5f7fa',
    100: '#ebeef3',
    200: '#d2d8e5',
    300: '#aab8cf',
    400: '#7d93b3',
    500: '#5c759b',
    600: '#495d80',
    700: '#3c4c68',
    800: '#344058',
    900: '#2f394b',
    950: '#161a23',
  },
  'charade': {
    50: '#f6f6f9',
    100: '#ecedf2',
    200: '#d5d7e2',
    300: '#afb3ca',
    400: '#848bac',
    500: '#656c92',
    600: '#505579',
    700: '#424662',
    800: '#393c53',
    900: '#333547',
    950: '#232431',
  },
};

module.exports = {
  content: [
    "./app/Views/**/*.{js,html,php}",
    "./app/Cells/**/*.php",
    "./app/Cells/components/**/*.{js,html,php}",
    "./public/js/**/*.js",
  ],
  safelist: [
    "bg-glass",
    "nav-menu-wrapper",
    "nav-menu-wrapper-on-top",
    "opacity-0",
    "opacity-100",
    "normal-input",
    "invalid-input",
  ],

  theme: {

    fontFamily: {
      'sans': ["Poppins", "ui-sans-serif", "system-ui", "-apple-system", "BlinkMacSystemFont", "Segoe UI", "Roboto", "Helvetica Neue", "Arial", "Noto Sans", "sans-serif", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"],
    },
    extend: {
      colors: colors,
    },
  },
  plugins: [],
}

