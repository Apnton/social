import './bootstrap';
import {createApp} from 'vue'
import App from './App.vue'
import router from "./router";
import '../css/app.css'
import components from '@/components/UI'
import {toast, updateGlobalOptions} from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { createPinia } from 'pinia';
import {toastConfig} from "@/config/toastConfig.js";


const app = createApp(App);
const pinia = createPinia();

components.forEach((item) => {
    app.component(item.name, item.component)
})

updateGlobalOptions(toastConfig);

app
    .component('toast', toast)
    .use(router)
    .use(pinia)
    .mount("#app")


