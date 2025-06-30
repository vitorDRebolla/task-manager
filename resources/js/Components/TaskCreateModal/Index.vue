<template>
  <div
    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
    @click.self="close"
  >
    <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg space-y-4">
      <h3 class="text-xl font-semibold text-center text-gray-800">
        Create New Task
      </h3>

      <form @submit.prevent="submit" class="space-y-4">
        <input
          v-model="form.title"
          type="text"
          placeholder="Title"
          required
          class="w-full border border-gray-300 rounded-md p-2 outline-none focus:ring-2 focus:ring-indigo-300"
        />

        <textarea
          v-model="form.description"
          placeholder="Description"
          required
          class="w-full h-24 border border-gray-300 rounded-md p-2 resize-none outline-none focus:ring-2 focus:ring-indigo-300"
        ></textarea>

        <input
          v-model="form.due_date"
          type="date"
          required
          class="w-full border border-gray-300 rounded-md p-2 outline-none focus:ring-2 focus:ring-indigo-300"
        />

        <div class="flex justify-end space-x-2">
          <button
            type="button"
            @click="close"
            class="cursor-pointer px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300"
          >
            Cancel
          </button>

          <button
            type="submit"
            :disabled="loading"
            class="cursor-pointer px-4 py-2 rounded-md bg-indigo-500 text-white hover:bg-indigo-600 disabled:opacity-50"
          >
            {{ loading ? 'Saving...' : 'Save' }}
          </button>
        </div>

        <p v-if="error" class="text-red-500 text-sm text-center">
          {{ error }}
        </p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { defineEmits } from 'vue'

const emits = defineEmits(['created', 'close'])

const form = useForm({
  title: '',
  description: '',
  due_date: '',
  status: 'OPENED',
})

function close() {
  emits('close')
}

function submit() {
  form.post('/tasks', {
    preserveScroll: true,
    onSuccess: () => {
      emits('created', form.data)
      close()
    },
  })
}
</script>

