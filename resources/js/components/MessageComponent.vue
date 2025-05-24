<!-- Componente que muestra un texto y un botón para cerrar -->
<template>
    <div :class="['info-message', messageType]" v-if="visible">
        <span class="message-content">{{ messageText }}</span>
        <button class="close-button" @click="closeMessage">❌</button>
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
        lang: {
            type: String,
            default: 'es',
        }
    },
    data() {
        return {
            visible: true,
        };
    },
    computed: {
        messageType() {
            // Obtener clases para los estilos dependiendo del texto de "message"
            switch (this.message) {
                case 'deliveryNotAdded':
                    return 'info-message--error';
                case 'deliveryAdded':
                    return 'info-message--success';
                case 'vehicleDeleted':
                    return 'info-message--success';
                case 'vehicleNotDeleted':
                    return 'info-message--error';
                case 'deliveryDeleted':
                    return 'info-message--success';
                case 'deliveryNotDeleted':
                    return 'info-message--error';
                case 'gestorNotDeleted':
                    return 'info-message--error';
                case 'transportistaNotDeleted':
                    return 'info-message--error';
                case 'formInvalid':
                    return 'info-message--error';
                case 'emailSent':
                    return 'info-message--success';
                case 'recordCreated':
                    return 'info-message--success';
                case 'recordDeleted':
                    return 'info-message--success';
                case 'shipmentCancelled':
                    return 'info-message--info';
                default:
                    return 'info-message--info';
            }
        },
        messageText() {
            // Mensaje que se devuelve dependiendo del idioma
            // Se crea un objeto con dos propiedades (una por idioma)
            const messages = {
                es: {
                    deliveryAdded: 'El envío fue asignado correctamente al reparto.',
                    deliveryNotAdded: 'El envío no se ha podido añadir porque se superaría la carga máxima.',
                    vehicleDeleted: 'Vehículo eliminado.',
                    vehicleNotDeleted: 'El vehículo tiene repartos activos.',
                    deliveryDeleted: 'Reparto eliminado.',
                    deliveryNotDeleted: 'El reparto tiene envíos asignados.',
                    gestorNotDeleted: 'Gestor no eliminado porque tiene repartos a su nombre.',
                    transportistaNotDeleted: 'Transportista no eliminado porque está asignado a algun reparto.',
                    formInvalid: 'Uno de los campos no es correcto.',
                    emailSent: 'Mensaje enviado correctamente.',
                    recordDeleted: 'Registro eliminado.',
                    recordCreated: 'Registro creado.',
                    shipmentCancelled: 'Envío anulado.'
                },
                en: {
                    deliveryAdded: 'The shipment was correctly assigned to the delivery.',
                    deliveryNotAdded: 'The shipment could not be added because the maximum load would be exceeded.',
                    vehicleDeleted: 'Vehicle deleted.',
                    vehicleNotDeleted: 'The vehicle has active deliveries.',
                    deliveryDeleted: 'Delivery route deleted.',
                    deliveryNotDeleted: 'The delivery route has assigned shipments.',
                    gestorNotDeleted: 'Traffic manager not deleted because he has created distributions.',
                    transportistaNotDeleted: 'Van driver not deleted because it is assigned to a delivery.',
                    formInvalid: 'One of the input fields is not correct.',
                    emailSent: 'Message sent successfully.',
                    recordDeleted: 'Record deleted.',
                    recordCreated: 'Record created.',
                    shipmentCancelled: 'Shipment cancelled'
                }
            };
            // Devolver string dependiendo del idioma y del tipo de mensaje
            return messages[this.lang]?.[this.message] || '';
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
    bottom: 30px;
    right: 20px;
    padding: 16px 24px;
    border-radius: 8px;
    font-size: 1.2rem;
    color: #fff;
    z-index: 1000;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    animation: aparecer 0.5s ease forwards;
    border: 2px solid lightgray;
}

.info-message--success {
    /* background-color: #04b34f; */
    background-color: #136F63;
}

.info-message--error {
    /* background-color: #a6192e; */
    background-color: #D00000;

}

.info-message--info {
    /* background-color: #0057b8; */
    background-color: #032B43;

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
        transform: translateX(100px);
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
        transform: translateX(100px);
    }
}

/* Estilo para cuando el mensaje desaparezca */
.info-message.desaparecer {
    animation: desaparecer 0.5s ease forwards;
}
</style>