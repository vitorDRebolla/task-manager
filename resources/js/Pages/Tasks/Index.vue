<template>
  <div class="p-8 bg-gray-50 min-h-screen">
    <div class="flex justify-between items-center mb-8">
      <div class="flex items-center gap-4">
        <div>
          <div class="flex gap-5">
            <Link
              href="/"
            >
              <button class="inline-flex items-center bg-indigo-600 text-white px-3 py-2 rounded-lg font-semibold shadow-lg hover:bg-indigo-700 transition cursor-pointer">
                ← Back
              </button>
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Task Board</h1>
          </div>
          <p class="text-gray-600">Organize your tasks by status and track progress effortlessly.</p>
        </div>
      </div>
      <button
        @click="showModal = true"
        class="inline-flex items-center bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold shadow-lg hover:bg-indigo-700 transition cursor-pointer"
      >
        <span class="mr-2">New Task</span>
      </button>
    </div>

    <TaskCreateModal
      v-if="showModal"
      :task="selectedTask"
      @created="onCreated"
      @close="onClose"
    />


    <div class="flex justify-center gap-6">
      <div
        v-for="(column, columnIndex) in columns"
        :key="column.status"
        :data-status-index="columnIndex"
        class="flex flex-col bg-white rounded-lg shadow-lg flex-shrink-0 w-full sm:w-1/2 lg:w-1/3 xl:w-1/4 max-h-[80vh]"
      >
        <div class="bg-indigo-100 p-4 rounded-t-lg flex items-center justify-between">
          <h2 class="text-lg font-semibold text-indigo-700">{{ column.label }}</h2>
          <span class="bg-indigo-200 text-indigo-800 text-sm font-semibold px-2 py-1 rounded-full">
            {{ tasksByStatus[column.status].length }}
          </span>
        </div>
          <p v-if="tasksByStatus[column.status].length === 0" class="text-center text-gray-400 italic mt-6">
            No tasks in this column
          </p>
          <Draggable
            v-model:list="tasksByStatus[column.status]"
            :group="{ name: 'tasks', pull: true, put: true }"
            item-key="id"
            @end="onDragEnd"
            class="flex-1 overflow-y-auto p-4 space-y-4 min-h-[100px]" :data-status="column.status"
          >
            <template #item="{ element }">
              <TaskCard
                :task="element"
                @deleted="removeTask"
                @edit="openEditModal"
              />
            </template>
          </Draggable>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import TaskCard from '@/Components/TaskCard/Index.vue'
import TaskCreateModal from '@/Components/TaskCreateModal/Index.vue'
import Draggable from 'vuedraggable';
import axios from 'axios';


const props = defineProps({ tasks: Array })

const showModal = ref(false)
const tasks = ref(props.tasks ?? [])

watch(() => props.tasks, (newTasks) => {
  tasks.value = newTasks ?? []
})

const columns = [
  { status: 'OPENED', label: 'To Do' },
  { status: 'IN_PROGRESS', label: 'In Progress' },
  { status: 'CLOSED', label: 'Done' },
]

const tasksByStatus = ref({
  OPENED: [],
  IN_PROGRESS: [],
  CLOSED: [],
})

watch(() => props.tasks, (newTasks) => {
  const grouped = { OPENED: [], IN_PROGRESS: [], CLOSED: [] }

  for (const task of newTasks ?? []) {
    grouped[task.status]?.push(task)
  }

  for (const status in grouped) {
    grouped[status].sort((a, b) => a.order - b.order)
  }

  tasksByStatus.value = grouped
}, { immediate: true })



function removeTask(id) {
  for (const status in tasksByStatus.value) {
    tasksByStatus.value[status] = tasksByStatus.value[status].filter(t => t.id !== id)
  }
}

const selectedTask = ref(null)

function openEditModal(task) {
  selectedTask.value = task
  showModal.value = true
}

function onCreated(newTask) {
  tasks.value.unshift(newTask)
  showModal.value = false
  selectedTask.value = null
}

function onClose(editedTask) {
  showModal.value = false
  selectedTask.value = null
  tasksByStatus.value[editedTask.status] = tasksByStatus.value[editedTask.status].map(task => task?.id === editedTask?.id ? editedTask : task);
}

function onDragEnd(evt) {
  const taskId = Number(evt.item.dataset.id)
  const toStatus = evt.to.closest('[data-status]')?.dataset.status
  const newIndex = evt.newIndex

  if (!toStatus) return

  const list = tasksByStatus.value[toStatus]

  list.forEach((task, index) => {
    task.order = index
    task.status = toStatus
  })

  axios.put(`/tasks/${taskId}/status`, {
    status: toStatus,
    order: newIndex,
  })

  axios.post('/tasks/reorder', {
    tasks: list.map(task => ({
      id: task.id,
      order: task.order,
      status: task.status,
    }))
  })
}





</script>
