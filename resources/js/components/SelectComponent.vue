<template>
    <div>
        <!-- Atributos dinámicos (:) -->
        <label :for="id">{{ label }}</label>
        <select :id="id" :name="name">
            <option value="" disabled selected hidden>
                {{ placeholder }}
            </option>
            <option v-for="option in options" :value="option" :key="option">
                {{ option }}
            </option>
        </select>
    </div>
</template>

<script setup>
defineProps({
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
        default: 'Seleccione una opción:',
    },
    // Texto por defecto al cargar el componente
    placeholder: {
        type: String,
        default: 'Seleccione un valor:',
    },
    // Elementos option (su valor se obtiene del controlador)
    options: {
        type: Array,
        required: true,
    },
});
</script>

<style scoped>
label {
    display: block;
    margin-bottom: 8px;
}

select {
    width: 25%;
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
    font-size: 14px;
}
</style>