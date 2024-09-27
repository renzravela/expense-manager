<script setup lang="js">
import { ref, computed } from 'vue';
import appIcon from '../../assets/expenses-icon.png';
import profile from '../../assets/user-profile-icon.png';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const auth = page.props.auth;

const isUserManagementOpen = ref(false);
const isExpenseManagementOpen = ref(false);

function toggleUserManagement() {
    isUserManagementOpen.value = !isUserManagementOpen.value;
}

function toggleExpenseManagement() {
    isExpenseManagementOpen.value = !isExpenseManagementOpen.value;
}

// Check if the user is an admin (user_type 1)
const isAdmin = computed(() => auth.user.user_type == 1);
</script>

<template>

    <Head>
        <link rel="icon" :href="appIcon" type="image/x-icon" />
    </Head>
    <div class="flex h-screen">
        <aside class="w-64 bg-indigo-500 text-white p-4 space-y-4">
            <div class="flex flex-col gap-3 space-x-4 mb-10">
                <img :src="profile" class="w-12 self-center h-12" />
                <div>
                    <p class="capitalize">{{ auth.user.name }} <span>({{ auth.user.role_name }})</span></p>
                </div>
            </div>
            <nav class="space-y-2">
                <Link href="/" class="block py-2 px-4 rounded hover:bg-indigo-700">Dashboard</Link>

                <!-- User Management - only visible for admins -->
                <div v-if="isAdmin">
                    <button @click="toggleUserManagement"
                        class="block w-full text-left py-2 px-4 rounded hover:bg-indigo-700">
                        User Management
                    </button>
                    <div v-if="isUserManagementOpen" class="ml-4 space-y-1 transition-all duration-300 overflow-hidden">
                        <Link href="/roles" class="block py-1 px-4 hover:bg-indigo-600">Roles</Link>
                        <Link href="/users" class="block py-1 px-4 hover:bg-indigo-600">Users</Link>
                    </div>
                </div>

                <!-- Expense Management - accessible to all users -->
                <div>
                    <button @click="toggleExpenseManagement"
                        class="block w-full text-left py-2 px-4 rounded hover:bg-indigo-700">
                        Expense Management
                    </button>
                    <div v-if="isExpenseManagementOpen"
                        class="ml-4 space-y-1 transition-all duration-300 overflow-hidden">
                        <div v-if="isAdmin">
                            <Link href="/categories" class="block py-1 px-4 hover:bg-indigo-600">Expense Categories
                            </Link>
                        </div>
                        <Link href="/expenses" class="block py-1 px-4 hover:bg-indigo-600">Expenses</Link>
                    </div>
                </div>
            </nav>
        </aside>

        <div class="flex-1">
            <header class="bg-indigo-200 text-black p-4">
                <nav class="flex items-center justify-end gap-10 max-w-screen-lg mx-auto">
                    <h1>Welcome to Expense Manager</h1>
                    <Link :href="route('logout')" method="post" as="button">
                    Log Out
                    </Link>
                </nav>
            </header>

            <main class="p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
