/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';

import { Form, HasError, AlertError } from 'vform'

import swal from 'sweetalert2'
window.swal = swal;



const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', swal.stopTimer)
    toast.addEventListener('mouseleave', swal.resumeTimer)
  }
})

window.toast = toast;


window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import VueRouter from 'vue-router'

Vue.use(VueRouter)


let routes = [
  {	path: '/dashboard', component: require('./components/Dashboard.vue').default},
  { path: '/calculation', component: require('./components/Calculation.vue').default},
  { path: '/maxsulot_turlari', component: require('./components/MaxsulotTurlari.vue').default},
  { path: '/harajat_turlari', component: require('./components/HarajatTurlari.vue').default},
  { path: '/klent_turlari', component: require('./components/KlentTurlari.vue').default},
  {	path: '/xomashyo', component: require('./components/Xom-ashyo.vue').default	},
  {	path: '/ishlab-chiqarish', component: require('./components/Ishlab-chiqarish.vue').default	},
  {	path: '/savdo', component: require('./components/Savdo.vue').default	},
  {	path: '/maxsulot', component: require('./components/Maxsulot.vue').default	},
  {	path: '/t-maxsulotlar', component: require('./components/Tayyor-maxsulotlar.vue').default	},
  {	path: '/yt-maxsulotlar', component: require('./components/Ytayyor-maxsulotlar.vue').default	},
  {	path: '/zakaz-olish', component: require('./components/Zakaz-olish.vue').default	},
  {	path: '/sklad', component: require('./components/Sklad.vue').default	},
  {	path: '/tm-skladi', component: require('./components/Tm-skladi.vue').default	},
  {	path: '/xom-ashyo-skladi', component: require('./components/Xom-ashyo-skladi.vue').default	},
  {	path: '/klentlar-oldi-berdisi', component: require('./components/Klentlar-oldi-berdisi.vue').default	},
  {	path: '/mol-yetkazuvchilar-oldi-berdisi', component: require('./components/Mol-yetkazuvchilar-oldi-berdisi.vue').default	},
  {	path: '/harajatlar', component: require('./components/Harajatlar.vue').default	},
  {	path: '/kassa', component: require('./components/Kassa.vue').default	},
  {	path: '/klentlar', component: require('./components/Klentlar.vue').default	},
  {	path: '/jurnal', component: require('./components/Jurnal.vue').default	},
  {	path: '/olchovlar', component: require('./components/Olchovlar.vue').default	},
  {	path: '/users', component: require('./components/Users.vue').default	},
  {	path: '/pul', component: require('./components/Pul.vue').default	},
]

const router = new VueRouter({
	mode: 'history',
  routes // short for `routes: routes`
})

Vue.filter('upText', function(text){
  text = text.toString()
  return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('myDate', function(created){
  return moment(created).format('MMMM Do YYYY');
})

window.Reload = new Vue();
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
); 

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
