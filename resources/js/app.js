/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Fragment from 'vue-fragment'
import VueRouter from 'vue-router'
import { store } from './store/store'


import router from './router/router.js';
import BootstrapVue from 'bootstrap-vue'
const axios = require('axios').default;

axios.defaults.baseURL = '/';

import VueQrcode from '@chenfengyuan/vue-qrcode';
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

import 'bootstrap-vue/dist/bootstrap-vue.css';


import moment from 'moment';
Vue.prototype.moment = moment

import Swal from 'sweetalert2'
window.Swal = Swal;

import { v4 as uuidv4 } from 'uuid';
window.uuidv4 = uuidv4;

// helpers
import Form from './Helpers/Form'

window.Form = Form


// import Form from 'vue-js-form-helper';
// window.Form = Form;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('Dashboard', require('./components/Dashboard.vue').default);
Vue.component(VueQrcode.name, VueQrcode);
Vue.use(BootstrapVue);
Vue.component("vSelect", vSelect);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 * 
 */



Vue.use(Fragment.Plugin);

const app = new Vue({
    el: '#wrapper',
    router,
    store,
});
