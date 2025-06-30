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
import { ref, watch, defineProps, defineEmits } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import axios from 'axios';

const props = defineProps({
  task: Object, 
})
const emit = defineEmits(['close', 'created'])

const form = ref({
  title: '',
  description: '',
  status: 'OPENED',
  due_date: '',
})

watch(
  () => props.task,
  (newTask) => {
    if (newTask) {
      form.value = {
        title: newTask.title,
        description: newTask.description,
        status: newTask.status,
        due_date: newTask.due_date,
      }
    } else {
      form.value = {
        title: '',
        description: '',
        status: 'OPENED',
        due_date: '',
      }
    }
  },
  { immediate: true }
)

function close() {
  emit("close")
}

function submit() {
  if (props.task) {
    axios.put(`/tasks/${props.task.id}`, form.value).then(({data}) => {
      emit('close', {...data.task, id: props.task.id})
    })
  } else {
    Inertia.post('/tasks', form.value, {
      onSuccess: (res) => {
        emit('created', res.props?.task) 
      },
    })
  }
}
</script>


