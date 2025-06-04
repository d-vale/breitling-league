import { createApp } from 'vue';
import { setDefaultHeaders, setDefaultBaseUrl } from '@/utils/fetchJson.js';
import App from './App.vue';
import {router} from './routes/router.js';

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

setDefaultHeaders({'X-CSRF-TOKEN': csrfToken});
const urlApi = document.querySelector('meta[name="api-base-url"]')?.getAttribute('content') ?? '';
setDefaultBaseUrl(urlApi);

const myApp = createApp(App);
myApp.use(router);
myApp.mount('#app');
    