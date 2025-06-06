<!-- Plantilla de componente modal -->
<template>
    <div v-if="show" class="contenedor">
        <div class="modal">
            <div class="interior">
                <span class="mensaje">{{ texts.confirmMessage }}</span>
                <div>
                    <button @click="confirmar" class="btn boton-rojo">{{ texts.confirm }}</button>
                    <button @click="$emit('close')" class="btn btn-secondary">{{ texts.cancel }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- Props y métodos -->
<script>
export default {
    name: 'ModalComponent',
    props: {
        // Booleano para indicar si el modal se muestra o no
        show: {
            type: Boolean,
            required: true,
        },
        // Para guardar la ruta la que se mandará si el usuario acepta el modal
        route: {
            type: String,
            required: true,
        },
        method: {
            type: String,
            required: true,
        },
        // Idioma
        lang: {
            type: String,
            default: 'es',
        },
    },
    computed: {
        // Devuelve los mensajes dependiendo del idioma
        texts() {
            const translations = {
                es: {
                    confirmMessage: '¿Deseas confirmar?',
                    confirm: 'Confirmar',
                    cancel: 'Cancelar'
                },
                en: {
                    confirmMessage: 'Do you want to confirm?',
                    confirm: 'Confirm',
                    cancel: 'Cancel'
                }
            };
            return translations[this.lang] || translations.es;
        }
    },
    methods: {
        // Si se acepta, se genera un formulario con sus atributos
        confirmar() {
            // Crear formulario
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = this.route;
            // Atributos para Blade de Laravel
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
            // Crear input para el formulario donde se indica el método http
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = this.method;
            form.appendChild(methodInput);
            // Ejecutar formulario
            document.body.appendChild(form); // Adjuntar formulario al body
            form.submit(); // Hacer submit en el formulario
        },
    },
};
</script>

<!-- Estilos para el fondo y el propio modal -->
<style scoped>
.contenedor {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 1;
}

.modal {
    /* Mostrar el modal por pantalla */
    display: block;
    background: white;
    padding: 2rem;
    box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
    max-width: 20%;
    text-align: center;
    font-size: 1.5rem;
    top: 10%;
    left: calc(50% - 200px);
    height: fit-content;
    border: 2px solid grey;
    border-radius: 10px;
    z-index: 2;
    /* Mostrar por encima del fondo */
}

.interior {
    display: flex;
    flex-direction: column;
}

button {
    margin: 0.5rem;
}
</style>
