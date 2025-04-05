import { createApp } from 'vue';
import ButtonComponent from './Components/ButtonComponent.vue';
import CardComponent from './components/CardComponent.vue';

// Botón
const buttonApp = createApp({});
buttonApp.component('button-component', ButtonComponent);
buttonApp.mount('#button-app');

// Card
const cardApp = createApp({});
cardApp.component('card-component', CardComponent);
cardApp.mount('#card-app');