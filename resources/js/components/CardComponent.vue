<template>
    <button @click="handleClick" class="card d-flex flex-row">
        <div class="card-title btn">
            <h3>{{ titleText }}</h3>
        </div>
        <div class="card-body">
            <p>{{ bodyText }}</p>
        </div>
        <!-- Agregar botón -->
        <!-- <div class="card-footer">
            <button @click="handleClick">{{ buttonText }}</button>
        </div> -->
    </button>
</template>

<script>
export default {
    name: 'CardComponent',
    props: {
        titleText: {
            type: String,
            default: 'Título',
        },
        bodyText: {
            type: String,
            default: 'Contenido de la tarjeta',
        },
        cardUrl: {
            type: String,
            required: true,
        }
        /*         buttonText: {
                    type: String,
                    default: 'Botón',
                },
                buttonUrl: {
                    type: String,
                    required: true,
                }, */
    },
    methods: {
        handleClick() {
            window.location.href = this.cardUrl;
        },
    },
};
</script>

<style scoped>
.card {
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 300px;
    margin: 16px auto;
    overflow: hidden;
    background-color: #FDF0D5;
    display: flex;
    align-items: center;
}

.card:hover {
    .card-title {
        background-color: lightgrey;
    }
}

.card-title {
    background-color: lightgrey;
    padding: 8px 16px;
    font-size: 30px;
    background-color: #FDF0D5;
}

.card-title>h3 {
    font-size: 3.5rem;
}

.card-body {
    padding: 16px;
    font-size: 2rem;
    color: #333;
}

/* .card-footer {
    display: flex;
    justify-content: flex-end;
    padding: 8px 16px;
    background-color: #f8f9fa;
} */

/* button {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 8px 12px;
    cursor: pointer;
    font-size: 14px;
}

button:hover {
    background-color: white;
} */
</style>