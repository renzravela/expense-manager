<script setup lang="js">
const props = defineProps({
  title: {
    type: String,
    default: 'My Expenses',
  },
  breadcrumbLinks: {
    type: Array,
    default: () => [
      { text: 'Expense Management', href: '#' },
      { text: 'Expenses', href: '#', isActive: true },
    ],
  },
});
</script>

<template>
  <div class="flex justify-between items-center p-4">
    <h1 class="text-xl font-semibold">{{ title }}</h1>
    <nav class="text-gray-500">
      <ol class="flex space-x-2">
        <li v-for="(link, index) in breadcrumbLinks" :key="index">
          <a :href="link.href" :class="{'text-black font-medium': link.isActive, 'hover:underline': !link.isActive}">
            {{ link.text }}
          </a>
          <span v-if="index < breadcrumbLinks.length - 1"> &gt; </span>
        </li>
      </ol>
    </nav>
  </div>
</template>
