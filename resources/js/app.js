import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { createPinia } from 'pinia'

const pages = import.meta.glob('./Pages/**/*.vue')

createInertiaApp({
  resolve: async (name) => {
    const importPage = pages[`./Pages/${name}.vue`]
    if (!importPage) {
      throw new Error(`Página ${name} não encontrada em /resources/js/Pages`)
    }
    const module = await importPage()
    return module.default
  },
  
  // 2) Setup padrão
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
    app.use(plugin)
    app.use(createPinia())
    app.mount(el)
  },
})

// Barra de progresso do Inertia
InertiaProgress.init()
