/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from "vue-router";
import App from './components/App.vue';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
// import AccountsComponent from './components/AccountsComponent.vue';
// import DealsComponent from './components/Deals/DealsComponent.vue';


/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/accounts', name: 'accounts', component: () => import('./components/Accounts/AccountsComponent.vue')
        },
        {
            path: '/deals', name: 'deals', component: () => import('./components/Deals/DealsComponent.vue')
        },
        {
            path: '/', redirect: {name: 'accounts'}
        },
    ]
})

const app = createApp({});

app.component('app-component', App);

// import ExampleComponent from './components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);

// import NavbarComponent from './components/NavbarComponent.vue';
// app.component('navbar-component', NavbarComponent);

// import AccountsComponent from './components/AccountsComponent.vue';
// app.component('accounts-component', AccountsComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

// const Swal = require('sweetalert2')
app.use(VueSweetalert2);

app.use(router).mount('#app');
