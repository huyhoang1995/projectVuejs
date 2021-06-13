
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.moment = require('moment');
window.myFunc = require('@libs/myFunc').default;
window.underscore = require('underscore');
window.$ = require('jquery');

//include parsley
window.Parsley = require('parsleyjs');
require('@libs/plugin/parsley/vi.js');

//include bootstrap notify
require('bootstrap-notify');
window.myNotify = require('@libs/myNotify.js').default;

//incudel bootbox
window.myBootbox = require('@libs/myBootbox').default;

//include service
window.service = {
    exampleService: require('@libs/service/exampleService').default,
    todolistService: require('@libs/service/todolistService').default
}

//include vue-paginate
import pagination from "vue-bootstrap-pagination";
Vue.component('pagination', pagination);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('todolist-component', require('./components/TodoListComponent.vue'));

const app = new Vue({
    el: '#app'
});
