<script setup lang="js">
import { reactive, computed } from 'vue';
import UpperLayout from "../Custom-Components/UpperLayout.vue";
import PieChart from "../Custom-Components/PieChart.vue";

const props = defineProps({
    total_expenses: Object,
});

// Conditionally set chart data based on whether there are expenses
const chartData = computed(() => {
    if (props.total_expenses.length > 0) {
        return {
            labels: props.total_expenses.map(expense => expense.category_name),
            datasets: [
                {
                    backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
                    data: props.total_expenses.map(expense => expense.total_amount)
                }
            ]
        };
    } else {
        return {
            labels: ['No Expense Data'], // Placeholder label
            datasets: [
                {
                    backgroundColor: ['#E0E0E0'], // Gray for empty chart
                    data: [0] // No data value
                }
            ]
        };
    }
});
</script>

<template>
    <div>

        <Head title="Dashboard" />
        <UpperLayout title="My Expenses" :breadcrumbLinks="[{ text: 'Dashboard', href: '/' }]" />

        <main class="p-6">
            <div class="flex gap-20">
                <div>
                    <table v-if="total_expenses.length > 0">
                        <thead>
                            <tr>
                                <th>Expense Categories</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, rowIndex) in total_expenses" :key="rowIndex">
                                <td>{{ row.category_name }}</td>
                                <td class="py-3 px-6">{{ row.total_amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-else>
                        <p class="mb-5">It looks like you don't have any expenses yet.</p>
                        <Link href="/expenses"
                            class="underline text-xl">
                            Go to Expense Folder >
                        </Link>
                    </div>
                </div>
                <div>
                    <PieChart :chartData="chartData" />
                </div>
            </div>
        </main>
    </div>
</template>
