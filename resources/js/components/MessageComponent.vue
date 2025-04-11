<template>
    <div :class="['info-message', messageType]" v-if="visible">
        <span class="message-content">{{ messageText }}</span>
        <button class="close-button" @click="closeMessage">Cerrar</button>
    </div>
</template>

<script>
export default {
    name: 'InfoMessage',
    props: {
        message: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            visible: true,
        };
    },
    computed: {
        messageType() {
            // 
            switch (this.message) {
                case 'deliveryNotAdded':
                    return 'info-message--error';
                case 'deliveryAdded':
                    return 'info-message--success';
                default:
                    return 'info-message--info'
            }
        },
        messageText() {
            // Texto para los mensajes de información
            switch (this.message) {
                case 'deliveryAdded':
                    return 'El envío fue asignado correctamente al reparto.';
                case 'deliveryNotAdded':
                    return 'El envío no se ha podido añadir porque se superaría la carga máxima.';
                case 'deliveryRemoved':
                    return 'El envío ha sido eliminado del reparto.';
            }
        },
    },
    mounted() {
        // Contador de cinco segundos para que el mensaje desaparezca
        setTimeout(() => {
            const mensaje = document.querySelector('.info-message');
            mensaje.classList.add('desaparecer'); // Añadir efecto desaparecer
            setTimeout(() => { // Tras el efecto, poner el mensaje no visible
                this.visible = false;
            }, 500);
        }, 5000);
    },
    // Método para cerrar el mensaje
    methods: {
        closeMessage() {
            this.visible = false;
        },
    },
};
</script>

<style scoped>
.info-message {
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 16px 24px;
    border-radius: 8px;
    font-size: 1.2rem;
    color: #fff;
    z-index: 1000;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    animation: aparecer 0.5s ease forwards;
}

.info-message--success {
    background-color: #04b34f;
}

.info-message--error {
    background-color: #a6192e;
}

.info-message--info {
    background-color: #0057b8;
}

.close-button {
    background-color: transparent;
    border: none;
    font-size: 1rem;
    cursor: pointer;
    margin-left: 1rem;
    color: #fff;
}

.close-button:hover {
    color: #ccc;
}

/* Efecto cuando aparece un mensaje */
@keyframes aparecer {
    from {
        opacity: 0;
        transform: translateX(30px);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Efecto para desaparecer */
@keyframes desaparecer {
    from {
        opacity: 1;
        transform: translateX(0);
    }

    to {
        opacity: 0;
        transform: translateX(30px);
    }
}

/* Estilo para cuando el mensaje desaparezca */
.info-message.desaparecer {
    animation: desaparecer 0.5s ease forwards;
}
</style>