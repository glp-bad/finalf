import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import appHelper from "@/plugin/appHelper";
import constantsComponent from "@/plugin/constantsComponent";

import VueAxios from 'vue-axios';
import axios    from 'axios';

import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import { fas } from '@fortawesome/free-solid-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { dom } from "@fortawesome/fontawesome-svg-core";

// import { faPhone } from "@fortawesome/free-solid-svg-icons";

// library.add(faPhone);
library.add(fas);
library.add(fab);
library.add(far);
dom.watch();

let app = createApp(App);

app.component("font-awesome-icon", FontAwesomeIcon);

// app.config.globalProperties.$vueUrlHosting = process.env.VUE_APP_URL_HOST; // global vbariable

app.use(store).use(router);
app.use(constantsComponent);
app.use(appHelper);
app.use(VueAxios, axios);
app.mount('#app');
