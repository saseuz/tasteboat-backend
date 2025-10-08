import '../css/app.css';

import { createApp, h } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/vue3'
import Layout from './Shared/Layout.vue'
import { ZiggyVue } from 'ziggy-js'
import config from './helpers/config';

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    const page = pages[`./Pages/${name}.vue`]

    if (page.default.layout === undefined) {
      page.default.layout = Layout
    }

    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .component('Link', Link)
      .component('Head', Head)
      .mount(el)
  },
  progress: {
    delay: 250,
    color: 'red',
    includeCSS: true,
    showSpinner: true,
  },
  title: title => `${config.app_name} - ${title}`,
})