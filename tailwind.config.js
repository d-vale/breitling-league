/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./index.html",
      "./src/**/*.{vue,js,ts,jsx,tsx}",
    ],
    theme: {
      extend: {
        colors: {
          'card-bg': 'var(--card-bg)',
          'bg-default': 'var(--bg-default)',
          'text-default': 'var(--text-default)',
          'sub-text-lighter': 'var(--sub-text-lighter)',
          'badge-bg': 'var(--badge-bg)',
          'badge-text': 'var(--badge-text)',
        }
      },
    },
    plugins: [],
  }