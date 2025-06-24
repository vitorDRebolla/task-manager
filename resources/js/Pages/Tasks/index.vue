<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Tasks</h1>
      <Link href="/tasks/create" class="btn">New Task</Link>
      <table class="min-w-full mt-4">
        <thead>
          <tr>
            <th class="px-4 py-2">Title</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Due Date</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="task in tasks.data" :key="task.id">
            <td class="border px-4 py-2">{{ task.title }}</td>
            <td class="border px-4 py-2">{{ task.status }}</td>
            <td class="border px-4 py-2">{{ task.due_date }}</td>
            <td class="border px-4 py-2">
              <Link :href="`/tasks/${task.id}/edit`" class="btn-sm">Edit</Link>
              <button @click="destroy(task.id)" class="btn-sm ml-2">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="mt-4">
        <Pagination :links="tasks.links" />
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useTaskStore } from '@/stores/taskStore';
  import { Link } from '@inertiajs/inertia-vue3';
  import Pagination from '@/Components/Pagination.vue';
  
  const store = useTaskStore();
  const tasks = ref({ data: [], links: [] });
  
  onMounted(async () => {
    await store.fetchTasks();
    tasks.value = store.tasks;
  });
  
  function destroy(id) {
    if (confirm('Are you sure?')) {
      axios.delete(`/tasks/${id}`).then(() => store.fetchTasks());
    }
  }
  </script>