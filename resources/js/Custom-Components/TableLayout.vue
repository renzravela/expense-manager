<script setup lang="js">
import { defineProps, ref } from 'vue';
import UpdateModal from './UpdateModal.vue';

const props = defineProps({
    theads: {
        type: Array,
        default: () => ['Display Name', 'Description', 'Created At']
    },
    tbody: {
        type: Array,
        required: true
    },
    layoutFor: {
        type: String,
        required: true
    },
    label: {
        type: String,
        default: 'Something'
    }
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("en-US", {
        year: "2-digit",
        month: "2-digit",
        day: "2-digit",
    });
}
const showUpdateModal = ref(false);
const updateData = ref({});

const fillInfo = (rowData) => {
    showUpdateModal.value = true;
    updateData.value = { ...rowData };
}
</script>

<template>
    <div v-if="$page.props.flash.message" class="alert alert-success bg-green-300 p-3 mb-3 text-wh">
        {{ $page.props.flash.message }}
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <!-- Always show the headers -->
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th v-for="(header, index) in theads" :key="index" class="py-3 px-6 text-left">
                        {{ header }}
                    </th>
                </tr>
            </thead>
            <!-- Conditionally render the table body -->
            <tbody class="text-gray-600 text-sm font-light">
                <template v-if="tbody.length > 0">
                    <template v-if="layoutFor === 'default'">
                        <tr v-for="(row, rowIndex) in tbody" :key="rowIndex"
                            @click="(row.id === 1 && row.name === 'Administrator') ? null : fillInfo(row)"
                            class="border-b border-gray-200 hover:bg-gray-100 cursor-pointer"
                            :class="{ 'cursor-not-allowed opacity-50': row.id === 1 && row.name === 'Administrator' }">
                            <td class="py-3 px-6">{{ row.name }}</td>
                            <td class="py-3 px-6">{{ row.description }}</td>
                            <td class="py-3 px-6">{{ formatDate(row.created_at) }}</td>
                        </tr>
                    </template>
                    <template v-else-if="layoutFor === 'users'">
                        <tr v-for="(row, rowIndex) in tbody" :key="rowIndex"
                            @click="row.user_type === '1' ? null : fillInfo(row)"
                            class="border-b border-gray-200 hover:bg-gray-100 cursor-pointer"
                            :class="{ 'cursor-not-allowed opacity-50': row.user_type === '1' }">
                            <td class="py-3 px-6">{{ row.name }}</td>
                            <td class="py-3 px-6">{{ row.email }}</td>
                            <td class="py-3 px-6">{{ row.role.name }}</td>
                            <td class="py-3 px-6">{{ formatDate(row.created_at) }}</td>
                        </tr>
                    </template>
                    <template v-else-if="layoutFor === 'expenses'">
                        <tr v-for="(row, rowIndex) in tbody" :key="rowIndex" @click="fillInfo(row)"
                            class="border-b border-gray-200 hover:bg-gray-100 cursor-pointer">
                            <td class="py-3 px-6">{{ row.category }}</td>
                            <td class="py-3 px-6">{{ row.amount }}</td>
                            <td class="py-3 px-6">{{ formatDate(row.date) }}</td>
                            <td class="py-3 px-6">{{ formatDate(row.created_at) }}</td>
                        </tr>
                    </template>
                </template>
                <!-- Show "No data exists" if the tbody is empty -->
                <template v-else>
                    <tr>
                        <td colspan="100%" class="text-center py-6 text-gray-600">
                            No data exists.
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
        <UpdateModal v-model:showModal="showUpdateModal" :label="label" :updateData="updateData" />
    </div>
</template>
