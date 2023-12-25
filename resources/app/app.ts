import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { createApp, h, type DefineComponent } from 'vue';
import { InertiaProgress } from '@inertiajs/progress';
import { createPinia } from 'pinia';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const pinia = createPinia()

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(
        `./pages/${name}.vue`, 
        import.meta.glob<DefineComponent>("./pages/**/*.vue")
    ),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(pinia)
            .use(ZiggyVue, Ziggy)
            .mount(el) as any;
    },
});

InertiaProgress.init({ color: '#4B5563' });
