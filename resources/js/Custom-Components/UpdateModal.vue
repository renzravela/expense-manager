<script setup lang="js">
import { defineEmits, ref } from 'vue';
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { usePage, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const { props } = usePage();
const categories = props.categories;
const roles = props.roles;

const updateProps = defineProps({
    showModal: Boolean,
    label: String,
    updateData: Object,
});
const emit = defineEmits(['update:showModal', 'update:updateData']);

const closeModal = () => {
    emit('update:showModal', false);
};

const updateInput = (key, value) => {
    emit('update:updateData', { ...updateProps.updateData, [key]: value });
};

const handleSubmit = () => {
    const form = useForm({ ...updateProps.updateData });
    console.log(form)
    const routeName = `${updateProps.label.toLocaleLowerCase()}.update`;

    form.put(route(routeName, updateProps.updateData.id), {
        onSuccess: () => {
            closeModal();
        },
        onError: (errors) => {
            console.log(errors)
        },
    });
};

const deleteRole = (roleId) => {
    const routeName = `${updateProps.label.toLocaleLowerCase()}.destroy`;

    Inertia.delete(route(routeName, { id: roleId }), {
        onSuccess: () => {
            console.log('Role deleted successfully');
            closeModal();
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};

const renderFields = () => {
    const fields = {
        Role: [
            { label: "Display Name", key: "name" },
            { label: "Description", key: "description" },
        ],
        User: [
            { label: "Name", key: "name" },
            { label: "Email Address", key: "email" },
            { label: "Role", key: "user_type", isSelect: true, options: roles },
        ],
        Category: [
            { label: "Display Name", key: "name" },
            { label: "Description", key: "description" },
        ],
        Expense: [
            { label: "Expense Category", key: "category_id", isSelect: true, options: categories },
            { label: "Amount", key: "amount" },
            { label: "Date", key: "date", type: "date" },
        ],
    };
    return fields[updateProps.label] || [];
};
</script>

<template>
    <Modal :show="updateProps.showModal" :max-width="'lg'" :closeable="true" @close="closeModal">
        <template v-slot>
            <div class="p-6">
                <h2 class="text-xl font-semibold">Update {{ updateProps.label }}</h2>
                <form class="mt-2" @submit.prevent="handleSubmit">
                    <template v-for="field in renderFields()" :key="field.key">
                        <div class="flex items-center justify-between space-x-2 mb-5">
                            <InputLabel :value="field.label" />
                            <div class="w-1/2">
                                <template v-if="field.isSelect">
                                    <select v-model="updateProps.updateData[field.key]"
                                        @change="updateInput(field.key, updateProps.updateData[field.key])"
                                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="" disabled>Select a category</option>
                                        <option v-for="option in field.options" :key="option.value"
                                            :value="option.id">
                                            {{ option.text || option.name }}
                                        </option>
                                    </select>
                                </template>
                                <template v-else>
                                    <input v-model="updateProps.updateData[field.key]"
                                        @input="updateInput(field.key, updateProps.updateData[field.key])"
                                        :type="field.type || 'text'"
                                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                </template>
                            </div>
                        </div>
                    </template>

                    <div class="flex justify-between">
                        <button type="button" @click="deleteRole(updateProps.updateData.id)" class="mt-5 w-24 px-4 py-2 bg-red-500 text-white rounded me-2">
                            Delete
                        </button>
                        <div>
                            <button type="button" @click="closeModal"
                                class="mt-5 w-24 px-4 py-2 bg-gray-500 text-white rounded me-2">
                                Cancel
                            </button>
                            <button type="submit" class="mt-5 w-24 px-4 py-2 bg-indigo-500 text-white rounded">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </template>
    </Modal>
</template>
