module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      backgroundImage: theme => ({
        'gym-texture': 'url(/img/gym.jpg)',
      })
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
