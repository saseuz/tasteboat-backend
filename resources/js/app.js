import '../css/app.css';

import { createApp, h } from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy-js';
import Layout from '@/Shared/Layout.vue'
import config from './helpers/config';

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]

    if (page.default.layout === undefined) {
      page.default.layout = Layout
    }
    
    return page
  },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })

    app.use(plugin)
    app.use(ZiggyVue)
    app.component('Link', Link)
    app.component('Head', Head)
    app.config.globalProperties.$config = config
    app.mount(el)
  },
  title: title => `${config.app_name} - ${title}`,
})