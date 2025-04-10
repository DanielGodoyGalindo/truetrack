import { createApp } from 'vue';
import ButtonComponent from './Components/ButtonComponent.vue';
import CardComponent from './components/CardComponent.vue';
import SelectComponent from './components/SelectComponent.vue';
import TableComponent from './components/TableComponent.vue';
import MessageComponent from './components/MessageComponent.vue';

// Botón
const buttonApp = createApp({});
buttonApp.component('button-component', ButtonComponent);
buttonApp.mount('#button-app');

// Card envios
const cardEnviosApp = createApp({});
cardEnviosApp.component('card-component', CardComponent);
cardEnviosApp.mount('#card-envios');

// Card repartos
const cardRepartosApp = createApp({});
cardRepartosApp.component('card-component', CardComponent);
cardRepartosApp.mount('#card-repartos');

// Select transportistas
const selectApp1 = createApp({});
selectApp1.component('select-component', SelectComponent);
selectApp1.mount('#select-app1');

// Select vehiculos
const selectApp2 = createApp({});
selectApp2.component('select-component', SelectComponent);
selectApp2.mount('#select-app2');

// Tabla
const tableApp = createApp({});
tableApp.component('table-component', TableComponent);
tableApp.mount('#table-app');

// Mensajes de información
const messageApp = createApp({});
messageApp.component('message-component', MessageComponent)
messageApp.mount('#message-app');

