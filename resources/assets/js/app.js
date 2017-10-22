
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('department', require('./components/Department.vue'));
Vue.component('tag', require('./components/Tag.vue'));
Vue.component('edit', require('./components/Edit.vue'));
Vue.component('department_head', require('./components/Department_head.vue'));

const app = new Vue({
    el: '#app'
});
