<script>
export default {
    data() {
        return {
            localData: [
                { "Envio Id": 1, "Destinatario": "Juan Gonzalez", "Bultos Kilos": "2 bultos - 14.60 kilos" },
            ],
            localColumns: ["Envio Id", "Destinatario", "Bultos Kilos"],
        };
    },
};
</script>
<template>
    <div>
        <h3>Componente Tabla</h3>
        <table>
            <thead>
                <tr>
                    <th v-for="col in localColumns" :key="col">{{ col }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in localData" :key="row['Envio Id']">
                    <td v-for="value in row" :key="value">{{ value }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>



<style scoped>
#table-app {
    width: 100%;
    overflow: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    border: 1px solid #ddd;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}
</style>