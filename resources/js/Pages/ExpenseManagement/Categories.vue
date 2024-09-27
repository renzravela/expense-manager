<script setup lang="js">
import UpperLayout from "@/Custom-Components/UpperLayout.vue";
import TableLayout from "@/Custom-Components/TableLayout.vue";
import AddModal from "@/Custom-Components/AddModal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

defineProps({
    categories: Object,
})

const showModal = ref(false);
const form = useForm({
    name: '',
    description: '',
})

const handleSubmit = () => {
    form.post(route("category.add"), {
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
    <Head title="Categories" />
    <UpperLayout
        title="Expense Categories"
        :breadcrumbLinks="[
            { text: 'Expense Management', href: '#' },
            { text: 'Expense Categories', href: '#' },
        ]"
    />
    <main class="p-6">
        <TableLayout :tbody="categories.data" layoutFor="default" label="Category"/>
        <div class="text-end">
            <button @click="showModal = true" class="button mt-10">
                Add Category
            </button>

            <AddModal v-model:showModal="showModal" label="Category">
                <form @submit.prevent="handleSubmit" class="mt-2">
                    <div class="flex items-center justify-between space-x-2 mb-5">
                        <InputLabel value="Display Name" />
                        <div class="w-1/2">
                            <span v-if="form.errors.name" class="text-red-500 text-center">{{ form.errors.name }}</span>
                            <input type="text" name="name" id="name" v-model="form.name"
                                class="rounded-md w border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between space-x-2">
                        <InputLabel value="Description" />
                        <div class="w-1/2">
                            <span v-if="form.errors.description" class="text-red-500">{{ form.errors.description
                                }}</span>
                            <input type="text" name="description" id="description" v-model="form.description"
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
