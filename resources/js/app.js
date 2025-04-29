import { createApp } from 'vue';
import ButtonComponent from './Components/ButtonComponent.vue';
import CardComponent from './components/CardComponent.vue';
import SelectComponent from './components/SelectComponent.vue';
import TableComponent from './components/TableComponent.vue';
import MessageComponent from './components/MessageComponent.vue';
import ModalComponent from './components/ModalComponent.vue';
import ProgressBarComponent from './components/ProgressBarComponent.vue';

const app = createApp({
    data() {
        return {
            showModal: false, // Para manejar el estado del modal
            route: '', // Ruta dinámica para el modal
        };
    },
    methods: {
        openModal(route, method) {
            this.route = route; // Establece la ruta para el modal
            this.showModal = true; // Muestra el modal
            this.method = method; // Método http
        },
        closeModal() {
            this.showModal = false; // Cierra el modal
        },
    },
});

app.component('button-component', ButtonComponent);
app.component('card-component', CardComponent);
app.component('select-component', SelectComponent);
app.component('table-component', TableComponent);
app.component('message-component', MessageComponent);
app.component('modal-component', ModalComponent);
app.component('progress-bar-component', ProgressBarComponent);
app.mount('#app');