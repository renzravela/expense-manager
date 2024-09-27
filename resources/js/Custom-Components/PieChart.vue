<script setup lang="ts">
import { ref } from 'vue';
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js';
import { Pie } from 'vue-chartjs';
ChartJS.register(ArcElement, Tooltip, Legend);

const props = defineProps<{
    chartData: {
        labels: string[];
        datasets: { backgroundColor: string[]; data: number[] }[];
    };
}>();

const chartOptions = ref({
    responsive: true,
    maintainAspectRatio: false
});
</script>

<template>
    <div class="chart-container">
        <Pie :data="chartData" :options="chartOptions" />
    </div>
</template>



<style scoped>
.chart-container {
    position: relative;
    width: 100%;
    height: 400px; /* Set a height for your chart */
}
</style>
