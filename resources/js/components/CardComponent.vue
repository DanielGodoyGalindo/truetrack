<!-- Plantilla para el componente -->
<template>
    <button @click="handleClick" class="card">
        <h3 class="card-title icono-grande btn">{{ titleText }}</h3>
        <p class="card-body">{{ bodyText }}</p>
    </button>
</template>

<!-- Propiedades y comportamientos -->
<script>
export default {
    name: 'CardComponent',
    props: {
        // Titulo
        titleText: {
            type: String,
            default: 'Título',
        },
        // Texto principal
        bodyText: {
            type: String,
            default: 'Contenido de la tarjeta',
        },
        // Dirección url al hacer click en la tarjeta
        cardUrl: {
            type: String,
            required: true,
        }
    },
    methods: {
        // Ejecutar al hacer click
        handleClick() {
            window.location.href = this.cardUrl;
        },
    },
};
</script>

<!-- Estilos para solo este componente (scoped) -->
<style scoped>
.card {
    border: 1px solid #ccc;
    border-radius: 12px;
    box-shadow: 5px 5px 6px rgba(0, 0, 0, 0.1);
    margin: 1rem auto;
    background-color: #FDF0D5;
    height: 8rem;
    width: 20rem;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
}

.card:hover {
    .card-title {
        background-color: lightgrey;
    }
}

.card-title {
    padding: 8px 16px;
    background-color: #FDF0D5;
    align-self: center;
    font-size: 3.5rem;
}

.card-body {
    font-size: 2rem;
    align-self: center;
    margin-top: 1rem;
}
</style>