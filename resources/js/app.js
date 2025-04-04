import { createApp } from 'vue';
import ButtonComponent from './Components/ButtonComponent.vue';

// Botón
const buttonApp = createApp({});
buttonApp.component('button-component', ButtonComponent);
buttonApp.mount('#button-app');