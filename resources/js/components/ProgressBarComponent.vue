<template>
    <div>
        <div class="progress mt-3 mb-3">
            <!-- Mostrar dos colores dentro de la barra. El primero es el porcentaje calculado y el segundo el restante -->
            <div class="progress-bar progress-bar-striped boton-accion1" role="progressbar"
                :style="{ width: porcentaje + '%' }" :aria-valuenow="valor" aria-valuemin="0" :aria-valuemax="total">
            </div>
            <div class="progress-bar progress-bar-striped bg-secondary" role="progressbar"
                :style="{ width: (100 - porcentaje) + '%' }" :aria-valuenow="total - valor" aria-valuemin="0"
                :aria-valuemax="total"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProgressBar",
    props: {
        // Porcentaje de la barra
        valor: {
            type: Number,
            required: true,
        },
        // Total
        total: {
            type: Number,
            required: true,
        },
    },
    // Cálculo del porcentaje
    computed: {
        porcentaje() {
            if (this.total == 0)
                return 0;
            return (this.valor * 100) / this.total;
        },
    }
};
</script>
