require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

import router from './Router/router';
import store from './Store/store';
import App from './App.vue'
import _ from 'lodash'

Vue.use(VueRouter)
Object.defineProperty(Vue.prototype, '$_', { value: _ });
window.eventBus = new Vue()

const app = new Vue({
    el: '#app',
    router,
    store,
    components: { App }
})
