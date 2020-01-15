/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VueQrcodeReader from "vue-qrcode-reader";
import axios from "axios";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

require("./bootstrap");

window.Vue = require("vue");
window.Swal = require("sweetalert2");
window.qrcode = require("qrcode-generator");

Vue.use(VueQrcodeReader);
Vue.prototype.axios = axios;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: "74ef9f2f486751e74f0d",
    cluster: "us2",
    forceTLS: true
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <examplnpm audit e-component></examplnpm>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component("device-index", require("./components/device/Index.vue").default);

Vue.component("employee", require("./components/employee/Index.vue").default);
Vue.component(
    "employee-login",
    require("./components/employee/Login.vue").default
);
Vue.component(
    "employee-scan",
    require("./components/employee/Scan.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});
