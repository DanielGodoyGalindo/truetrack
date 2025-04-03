<template>
    <button @click="handleClick" class="btn">
        {{ buttonText }}
    </button>
</template>

<script>
export default {
    name: 'ButtonComponent',
    props: {
        buttonText: {
            type: String,
            default: 'Haz click',
        },
    },
    methods: {
        handleClick() {
            window.location.href = '/envios/create';
        },
    },
};
</script>

<!-- <style scoped>
.btn {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}
</style>
 -->