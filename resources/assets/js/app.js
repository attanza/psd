require('./bootstrap');
window.Vue = require('vue');
window.eventBus = new Vue({});

import VeeValidate from 'vee-validate'
Vue.use(VeeValidate)

import * as VueGoogleMaps from 'vue2-google-maps'
Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyAxV7vpqTfKc1PdTeCfKnh-zv3W6_umka8',
    libraries: 'places'
  }
})

require('./components');

import {
  store
} from './store'
const app = new Vue({
  el: '#app',
  store
});
