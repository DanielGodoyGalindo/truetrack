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
        buttonUrl: {
            type: String,
            required: true,
        },
    },
    methods: {
        handleClick() {
            window.location.href = this.buttonUrl;
        },
    },
};
</script>

<style scoped>
</style>