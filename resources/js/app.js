import './bootstrap';
import ujs from '@rails/ujs';
import Alpine from 'alpinejs';
import {createApp} from 'vue';
import {createRouter, createWebHistory} from 'vue-router'
import App from './App.vue';
import ProdList from './components/Product-listing.vue';

window.Alpine = Alpine;

ujs.start();
Alpine.start();

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/products',
            name: 'Products',
            component: ProdList
        },
    ]
})

createApp(App).use(router).mount("#prodlist");
