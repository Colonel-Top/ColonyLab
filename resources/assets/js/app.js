
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);
import CourseIndex from './components/Course/CourseIndex.vue';
import CourseCreate from './components/Course/CourseCreate.vue';
import CourseEdit from './components/Course/CourseEdit.vue';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const routes = [
	{
		path:'/',
		components:{
			courseIndex: CourseIndex
		}
	},
	{path:'/admin/Course/create', component: CourseCreate, name: 'createCourse'},
	{path: '/admin/Course/edit/:id', component: CourseEdit, name: 'editCourse'},
]
const router = new VueRouter({routes})
const app = new Vue({router}).$mount('#app')

