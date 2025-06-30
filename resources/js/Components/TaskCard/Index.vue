<template>
  <div
      class="bg-white shadow-md rounded-lg p-4 hover:shadow-lg transition-shadow mb-4 cursor-pointer"
     :data-id="task.id"
  >
    <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ task.title }}</h3>
    <span>{{ task.description }}</span>
    <p class="text-sm text-gray-500 mb-4">Due: {{ formatDate(task.due_date) }}</p>
    <div class="flex items-center justify-end gap-2">
      <button
        @click="emit('edit', task)"
        class="text-blue-600 hover:bg-blue-100 rounded-full p-2 transition-colors cursor-pointer"
        title="Edit Task"
      >
        ✏️
      </button>
      <button
        @click="showConfirm = true"
        class="text-red-600 hover:bg-red-100 rounded-full p-2 transition-colors cursor-pointer"
        title="Delete Task"
      >
        🗑️
      </button>
    </div>

    <div v-if="showConfirm" class="fixed inset-0 flex items-center justify-center bg-black/40" @click.self="showConfirm = false">
      <div class="bg-white rounded-lg p-6 w-80">
        <h4 class="text-lg font-semibold mb-4">Remove task?</h4>
        <p class="text-gray-600 mb-6">Are you sure you want to delete this task?</p>
        <div class="flex justify-end gap-2">
          <button @click="showConfirm = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 cursor-pointer">Cancel</button>
          <button 
            @click.prevent="confirmDelete" 
            type="button" 
            :disabled="isDeleting"
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="isDeleting">Deleting...</span>
            <span v-else>Delete</span>
          </button>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { defineEmits } from 'vue';
import axios from 'axios';

const props = defineProps({
  task: Object,
})

const emit = defineEmits(['deleted', 'edit']);

const showConfirm = ref(false)

function formatDate(date) {
  return new Date(date).toLocaleDateString()
}

const isDeleting = ref(false)

function confirmDelete() {
  isDeleting.value = true;

  axios.delete(`/tasks/${props.task.id}`).then(() => {
    showConfirm.value = false;
    emit('deleted', props.task.id);
  }).finally(() => {
    isDeleting.value = false;
  });
}

</script>
