export default {
  // Disable server-side rendering (https://go.nuxtjs.dev/ssr-mode)
  ssr: true,

  // Target (https://go.nuxtjs.dev/config-target)
  target: 'server',

  // Global page headers (https://go.nuxtjs.dev/config-head)
  head: {
    title: 'finalFront',
    meta: [
      {charset: 'utf-8'},
      {name: 'viewport', content: 'width=device-width, initial-scale=1'},
      {hid: 'description', name: 'description', content: ''}
    ],
    link: [
      {rel: 'icon', type: 'image/x-icon', href: '/favicon.ico'}
    ]
  },

  // Global CSS (https://go.nuxtjs.dev/config-css)
  css: ['~assets/css/custom.css'],

  // Plugins to run before rendering page (https://go.nuxtjs.dev/config-plugins)
  plugins: [
    '~plugins/i18n.js',
    '~/plugins/Vuelidate',
    '~/plugins/modal',
  ],

  // Auto import components (https://go.nuxtjs.dev/config-components)
  components: true,

  // Modules for dev and build (recommended) (https://go.nuxtjs.dev/config-modules)
  buildModules: [
    '@nuxtjs/dotenv',
  ],

  // Modules (https://go.nuxtjs.dev/config-modules)
  modules: [
    // https://go.nuxtjs.dev/bootstrap
    'bootstrap-vue/nuxt',
    '@nuxtjs/axios',
    '@nuxtjs/auth-next',
    '@nuxtjs/toast',
  ],
  // Build Configuration (https://go.nuxtjs.dev/config-build)
  build: {
    vendor: ['vue-i18n'],
  },

  router: {
    middleware: ['i18n', 'auth']
  },

  axios: {
    credentials: true,
    proxy: true,
  },

  auth: {
    plugins: ['~/plugins/auth.js'],
    strategies: {
      local: {
        scheme: 'local',
        user: {
          property: false,
          autoFetch: true
        },
        token: {maxAge: 3600},
        endpoints: {
          csrf: {url: '/sanctum/csrf-cookie'},
          login: {url: '/api/login', method: 'post', property: 'token'},
          logout: {url: '/api/logout', method: 'get'},
          user: {url: '/api/user', method: 'get'}
        },
      },
      localRemember: {
        scheme: 'local',
        user: {
          property: false,
          autoFetch: true
        },
        token: {maxAge: 14 * 24 * 60 * 60},
        endpoints: {
          csrf: {url: '/sanctum/csrf-cookie'},
          login: {url: '/api/login', method: 'post', property: 'token'},
          logout: {url: '/api/logout', method: 'get'},
          user: {url: '/api/user', method: 'get'}
        },
      }
    },
    redirect: {
      login: '/auth/login',
      logout: '/auth/login',
      callback: '/home',
      home: '/home'
    },
  },
  proxy: {
    '/api/': "http://api.com",
    '/sanctum/csrf-cookie': "http://api.com",

  },
  bootstrapVue: {
    icons: true
  },
  toast: {
    position: 'bottom-right',
    duration: 5000,
    singleton: true
  }

}
