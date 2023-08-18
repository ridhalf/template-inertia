import { createApp, h } from 'vue'
import {createInertiaApp, Link} from '@inertiajs/vue3'
import App from "./Pages/App.vue";
import LayoutAuth from "./Pages/Auth/LayoutAuth.vue";

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
      const page = pages[`./Pages/${name}.vue`];
      // page.default.layout = page.default.layout || App
      if (name.startsWith('Auth/')){
          page.default.layout ??= LayoutAuth;
      }else{
          page.default.layout ??= App;
      }
      return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
        .component("Link",Link)
      .mount(el)
  },
})
