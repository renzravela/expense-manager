<script setup lang="js">
import UpperLayout from "@/Custom-Components/UpperLayout.vue";
import TableLayout from "@/Custom-Components/TableLayout.vue";
import AddModal from "@/Custom-Components/AddModal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

defineProps({
    expenses: Object,
    categories: Object,
})

const showModal = ref(false);
const form = useForm({
    category_id: '',
    amount: '',
    date: '',
})

const headers = ['Expense Category', 'Amount', 'Entry Date', 'Created At'];

const handleSubmit = () => {
    form.post(route("expense.add"), {
        onSuccess: () => {
            showModal.value = false;
            form.reset();
        },
        onError: (errors) => {
            console.error("Validation errors:", errors);
        },
    });
}
</script>
<template>

    <Head title="Expenses" />
    <UpperLayout title="Expenses" :breadcrumbLinks="[
        { text: 'Expense Management', href: '#' },
        { text: 'Expenses', href: '#' },
    ]" />

    <main class="p-6">
        <TableLayout :theads="headers" :tbody="expenses" layoutFor="expenses" label="Expense" />
        <div class="text-end">
            <button @click="showModal = true" class="button mt-10">
                Add Expense
            </button>

            <AddModal v-model:showModal="showModal" label="Expense">
                <form @submit.prevent="handleSubmit" class="mt-2">

                    <div class="flex items-center justify-between space-x-2 mb-5">
                        <InputLabel value="Expense Category" />
                        <div class="w-1/2">
                            <span v-if="form.errors.category_id" class="text-red-500">{{ form.errors.category_id
                                }}</span>
                            <select name="category_id" id="category_id" v-model="form.category_id"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option disabled value="">Select Expense Category</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-between space-x-2 mb-5">
                        <InputLabel value="Amount" />
                        <div class="w-1/2">
                            <span v-if="form.errors.amount" class="text-red-500">{{ form.errors.amount
                                }}</span>
                            <input type="text" name="amount" id="amount" v-model="form.amount"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between space-x-2 mb-5">
                        <InputLabel value="Entry Date" />
                        <div class="w-1/2">
                            <span v-if="form.errors.date" class="text-red-500">{{
                                form.errors.date
                                }}</span>
                            <input type="date" name="date" id="date" v-model="form.date"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="button" @click="() => { showModal = false; form.reset() }"
                            class="mt-5 w-24 px-4 py-2 bg-gray-500 text-white rounded me-2">Cancel</button>
                        <button type="submit" class="mt-5 w-24 px-4 py-2 bg-indigo-500 text-white rounded">Save</button>
                    </div>
                </form>
            </AddModal>
        </div>
    </main>
</template>
