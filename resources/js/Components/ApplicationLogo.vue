<script setup lang="js">
import expense_icon from '../../assets/expenses-icon.png';
</script>

<template>
    <div class="rounded-lgp-10 h-1/2 flex items-center justify-center">
        <img
            :src="expense_icon"
            alt="Expense Manager Icon"
            class="mr-4 transition duration-300 transform hover:scale-110"
            height="50"
            width="50"
        />
        <h1 class="text-2xl font-semibold text-gray-800">Expense Manager</h1>
    </div>
</template>

<style scoped>
/* Optional: Additional custom styles */
</style>
