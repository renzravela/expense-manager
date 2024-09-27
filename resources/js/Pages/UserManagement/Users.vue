<script setup lang="js">
import UpperLayout from "@/Custom-Components/UpperLayout.vue";
import TableLayout from "@/Custom-Components/TableLayout.vue";
import AddModal from "@/Custom-Components/AddModal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";

const headers = ['Name', 'Email Address', 'Role', 'Created At'];

defineProps({
    users: Object,
    roles: Object,
})
const showModal = ref(false);
const form = useForm({
    name: '',
    email: '',
    user_type: '',
    password: '',
    confirm_password: '',
})
watch(() => form.password, () => {
    validatePassword();
});

watch(() => form.confirm_password, () => {
    validatePassword();
});

const validatePassword = () => {
    if (form.password !== form.confirm_password) {
        form.errors.confirm_password = "Passwords do not match.";
    } else {
        delete form.errors.confirm_password;
    }
};

const handleSubmit = () => {

    validatePassword();

    if (Object.keys(form.errors).length === 0) {
        form.post(route("user.add"), {
            onSuccess: () => {
                showModal.value = false;
                form.reset();
            },
            onError: (errors) => {
                console.error("Validation errors:", errors);
            },
        });
    }
};
</script>
<template>

    <Head title="Users" />
    <UpperLayout title="Users" :breadcrumbLinks="[
        { text: 'User Management', href: '#' },
        { text: 'Users', href: '#' },
    ]" />

    <main class="p-6">
        <TableLayout :theads="headers" :tbody="users.data" layoutFor="users" label="User" />
        <div class="text-end">
            <button @click="showModal = true" class="button mt-10">
                Add User
            </button>

            <AddModal v-model:showModal="showModal" label="User">
                <form @submit.prevent="handleSubmit" class="mt-2">
                    <div class="flex items-center justify-between space-x-2 mb-5">
                        <InputLabel value="Name" />
                        <div class="w-1/2">
                            <span v-if="form.errors.name" class="text-red-500 text-center">{{ form.errors.name }}</span>
                            <input type="text" name="name" id="name" v-model="form.name"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between space-x-2 mb-5">
                        <InputLabel value="Email" />
                        <div class="w-1/2">
                            <span v-if="form.errors.email" class="text-red-500">{{ form.errors.email
                                }}</span>
                            <input type="email" name="email" id="email" v-model="form.email"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between space-x-2 mb-5">
                        <InputLabel value="Role" />
                        <div class="w-1/2">
                            <span v-if="form.errors.user_type" class="text-red-500">{{ form.errors.user_type }}</span>
                            <select name="user_type" id="user_type" v-model="form.user_type"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option disabled value="">Select User Role</option>
                                <option v-for="role in roles" :key="role.id" :value="role.id">
                                    {{ role.name }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-between space-x-2 mb-5">
                        <InputLabel value="Password" />
                        <div class="w-1/2">
                            <span v-if="form.errors.password" class="text-red-500">{{ form.errors.password
                                }}</span>
                            <input type="password" name="password" id="password" v-model="form.password"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between space-x-2 mb-5">
                        <InputLabel value="Confirm Password" />
                        <div class="w-1/2">
                            <span v-if="form.errors.confirm_password" class="text-red-500">{{
                                form.errors.confirm_password
                                }}</span>
                            <input type="password" name="confirm_password" id="confirm_password"
                                v-model="form.confirm_password"
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
