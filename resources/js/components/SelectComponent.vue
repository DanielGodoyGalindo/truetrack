<template>
    <div>
        <label :for="id">{{ label }}</label>
        <select :id="id">
            <option value="" disabled selected hidden>
                {{ placeholder }}
            </option>
            <option v-for="option in options" :value="option" :key="option">
                {{ option }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    props: {
        id: {
            type: String,
            required: true,
        },
        // Etiqueta incluida en el componente
        label: {
            type: String,
            default: 'Seleccione una opción:',
        },
        // Valor por defecto en el select
        placeholder: {
            type: String,
            default: 'Seleccione un transportista',
        },
        // Elementos option (se incluirán con una variable generada por el controlador)
        options: {
            type: Array,
            required: true,
        },
    },
};
</script>

<style scoped>
label {
    display: block;
    margin-bottom: 8px;
    /* font-weight: bold; */
}

select {
    width: 25%;
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
    font-size: 14px;
}
</style>