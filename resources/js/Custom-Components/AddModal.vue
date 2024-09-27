<script setup lang="js">
import { defineEmits } from 'vue';
import Modal from "@/Components/Modal.vue";


const props = defineProps({
    showModal: Boolean,
    label: String
});
const emit = defineEmits(['update:showModal']);

const closeModal = () => {
    emit('update:showModal', false);
};
</script>

<template>
    <!-- Modal component -->
    <Modal :show="props.showModal" :max-width="'lg'" :closeable="true" @close="closeModal">
        <template v-slot>
            <div class="p-6">
                <h2 class="text-xl font-semibold">
                    Add {{ label }}
                </h2>
                <slot></slot>
            </div>
        </template>
    </Modal>
</template>
