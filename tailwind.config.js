/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        // Couleurs Breitling
        'breitling': '#ffc629',
        'breitling-blue': '#072c54',
        
        // Métaux
        'bronze': '#cd7f32',
        'gold': '#ffc629',
        'silver': '#949494',
        'platine': '#42b3a7',
        
        // Couleurs spéciales
        'diamond': '#b9f2ff',
        
        // Couleurs fonctionnelles
        'bonus-green': '#60da7a',
        'malus-red': '#dc2543',
      }
    },
  },
  plugins: [],
}