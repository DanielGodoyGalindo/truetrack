<template>
    <div>
        <!-- Atributos dinámicos (:) -->
        <label v-if="label != ''" :for="id">{{ label }}</label>
        <select :id="id" :name="name" v-model="internalValue">
            <!-- <option disabled selected>Selecciona un opción</option> -->
            <option v-for="option in options" :value="option" :key="option">
                {{ option }}
            </option>
        </select>
    </div>
</template>

<script setup>

import { ref } from 'vue';

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    // Se usa para guardar el valor seleccionado por el usuario
    name: {
        type: String,
        required: true,
    },
    // Etiqueta que se incluye encima del select
    label: {
        type: String,
        default: 'Selecciona una opción:',
    },
    // Elementos option (su valor se obtiene del controlador)
    options: {
        type: Array,
        required: true,
    },
    selected: {
        type: String,
        default: '',
    }
    // Texto por defecto al cargar el componente
    /*     placeholder: {
            type: String,
            default: 'Seleccione un valor:',
        }, */
});

// Crear variable reactiva que recibe el valor de la prop selected
// Si no se recibe, se elige el primer option del elemento
const internalValue = ref(props.selected || (props.options.length > 0 ? props.options[0] : ''))

</script>

<style scoped>
label {
    display: block;
    /* margin-bottom: 8px; */
}

select {
    width: 200px;
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
    font-size: 14px;
    margin-bottom: 20px;
}
</style>