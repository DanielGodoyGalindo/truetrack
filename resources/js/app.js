import { createApp } from 'vue';
import ButtonComponent from './Components/ButtonComponent.vue';

const app = createApp({});
app.component('button-component', ButtonComponent);
app.mount('#app');
