import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'
import Aura from '@primeuix/themes/aura';
import PrimeVue from 'primevue/config';
import { setupCalendar, Calendar, DatePicker } from 'v-calendar';
import 'v-calendar/style.css';
import VueClickAway from 'vue3-click-away';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';


createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./views/**/*.vue', {eager: true})
        return pages[`./views/${name}.vue`]
    },
    setup({el, App, props, plugin}) {
        createApp({
            render: () => h(App, props)
        })
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                    options: {
                        prefix: 'p',
                        darkModeSelector: 'system',
                        cssLayer: false
                    }
                }
            })
            .use(VueSweetalert2)
            .use(VueClickAway)
            .use(setupCalendar, {})
            .component('VCalendar', Calendar)
            .component('VDatePicker', DatePicker)
            .use(plugin)
            .mount(el)
    },
})
