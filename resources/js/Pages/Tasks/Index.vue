<template>
  <div class="p-4">
    <div class="flex justify-start mb-4 px-9">
      <button
        @click="showModal = true"
        class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white px-5 py-2 rounded-lg font-semibold shadow-md transform transition hover:scale-105 cursor-pointer"
      >
        New Card
      </button>
    </div>

    <TaskCreateModal
      v-if="showModal"
      @created="onCreated"
      @close="showModal = false"
    />

    <div class="flex justify-center gap-15 overflow-x-auto py-4">
      <div
        v-for="column in columns"
        :key="column.status"
        class="flex-shrink-0 w-72 bg-gray-100 rounded-lg flex flex-col max-h-[calc(100vh-4rem)]"
      >
        <h2 class="bg-gray-300 p-3 text-center font-bold rounded-t-lg">
          {{ column.label }}
        </h2>
        <div class="flex-1 p-3 overflow-y-auto">
          <TaskCard
            v-for="task in filteredTasks(column.status)"
            :key="task.id"
            :task="task"
            @delete="destroy"
          />
          <p v-if="filteredTasks(column.status).length === 0" class="text-center text-gray-500 italic">
            No tasks
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useTaskStore } from '@/stores/taskStore'
import TaskCard from '@/Components/TaskCard/Index.vue'
import TaskCreateModal from '@/Components/TaskCreateModal/Index.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  tasks: Object,
})

const store = useTaskStore()
const tasks = ref([])
const showModal = ref(false)

const columns = [
  { status: 'todo', label: 'To Do' },
  { status: 'in_progress', label: 'In Progress' },
  { status: 'done', label: 'Done' },
]

onMounted(async () => {
  await getTasks()
})

function filteredTasks(status) {
  return tasks.value.filter(t => t.status === status)
}

function destroy(id) {
  if (confirm('Are you sure you want to delete?')) {
    axios.delete(`/tasks/${id}`)
      .then(async () => {
        await store.fetchTasks()
        tasks.value = store.tasks.data
      })
  }
}

async function getTasks() {
  await store.fetchTasks()
  tasks.value = store.tasks.data
}

async function onCreated(newTask) {
  store.tasks.unshift(newTask) 
  tasks.value = store.tasks
  showModal.value = false
}

</script>
