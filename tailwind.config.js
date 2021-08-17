module.exports = {
  purge: [],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      height: theme => ({
        "screen-navbar": "calc(100vh - 64px)",
        "screen/2": "50vh",
        "screen/3": "calc(100vh / 3)",
        "screen/4": "calc(100vh / 4)",
        "screen/5": "calc(100vh / 5)",
      }),
      width: theme => ({
        "screen/2": "50vw",
        "screen/3": "calc(100vw / 3)",
        "screen/4": "calc(100vw / 4)",
        "screen/5": "calc(100vw / 5)",
        "screen/6": "calc(100vw / 6)",
        "screen/8": "calc(100vw / 8)",
        "screen/10": "calc(100vw / 10)",
      })
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
