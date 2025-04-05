<template>
    <table class="table">
        <thead>
            <tr>
                <th v-for="column in columns" :key="column.key || column.label">
                    {{ column.label }}
                </th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in data" :key="row.id">
                <td v-for="column in columns" :key="column.key || column.label">
                    {{ getValue(row, column.key) }}
                </td>
                <td>
                    <button @click="deleteRecord(row.id)" class="btn btn-danger">
                        Borrar
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: 'TableComponent',
    props: {
        columns: {
            type: Array,
            required: true,
        },
        data: {
            type: Array,
            required: true,
        },
    },
    methods: {
        getValue(row, key) {
            return key ? key.split('.').reduce((acc, curr) => acc && acc[curr], row) : '';
        },
        async deleteRecord(id) {
            try {
                const response = await fetch(`/envios/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                });

                if (response.ok) {
                    // Eliminar registro del array local
                    this.data = this.data.filter(row => row.id !== id);
                    alert('Registro eliminado correctamente.');
                } else {
                    alert('Error al eliminar el registro.');
                }
            } catch (error) {
                console.error('Error en la solicitud:', error);
                alert('Ocurrió un error al intentar eliminar el registro.');
            }
        },
    },
};
</script>

<style scoped>
.table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background-color: #f8f9fa;
    font-weight: bold;
}

td,
th {
    padding: 10px;
    border: 1px solid #ddd;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 3px;
}

.btn-danger:hover {
    background-color: #c82333;
}
</style>
