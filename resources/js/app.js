import './bootstrap';
import ujs from '@rails/ujs';
import Alpine from 'alpinejs';
import {createApp} from 'vue';
import ProdList from './Product-listing.vue';
createApp(ProdList).mount("#prodlist");

ujs.start();
Alpine.start();