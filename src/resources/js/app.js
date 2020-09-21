require('./bootstrap');

// window.Vue = require('vue');

import Vue from 'vue';
import VueRouter from 'vue-router';

import Products from './components/Products.vue';
import Shop from './components/Shop.vue';
import Orders from './components/Orders.vue';
import App from './layout/App.vue';

Vue.use(VueRouter);


// const app = new Vue({
//     el: '#app'
// });


// 1. Define route components.
// These can be imported from other files
// const Foo = { template: '<div>foo</div>' }
// const Bar = { template: '<div>bar</div>' }

// 2. Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// `Vue.extend()`, or just a component options object.
// We'll talk about nested routes later.
const routes = [
  { path: '/shop',   component: Shop },
  { path: '/orders', component: Orders },
];

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
//   routes // short for `routes: routes`
    mode: "history",
    // base: process.env.BASE_URL,
    routes
});


// 4. Create and mount the root instance.
// Make sure to inject the router with the router option to make the
// whole app router-aware.
const app = new Vue({
    router,
    render: (h) => h(App)
  }).$mount('#app')