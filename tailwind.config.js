/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/css/**/*.css',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          light: '#90cdf4',  // Biru terang lembut
          DEFAULT: '#63b3ed', // Biru lembut sebagai warna utama
          dark: '#3182ce',    // Biru yang lebih gelap untuk kontras
        },
        secondary: {
          light: '#faf089',   // Kuning terang lembut
          DEFAULT: '#f6e05e', // Kuning lembut sebagai warna sekunder
          dark: '#ecc94b',    // Kuning yang lebih gelap untuk kontras
        },
        background: {
          light: '#f7fafc',   // Latar belakang terang
          dark: '#2d3748',    // Latar belakang gelap untuk dark mode
        },
        text: {
          light: '#2d3748',   // Warna teks untuk mode terang
          dark: '#e2e8f0',    // Warna teks untuk mode gelap
        },
      },
      fontFamily: {
        sans: ['Nunito', 'sans-serif'],
      },
    },
  },
  plugins: [],
  darkMode: 'class', // Mengaktifkan mode dark
}
