<template>
    <h3 class="task-title">{{ task.title }}</h3>
    <p class="task-date">Due: {{ formatDate(task.due_date) }}</p>
    <div class="task-actions">
        <Link 
        :href="`/tasks/${task.id}/edit`" 
        class="btn-edit"
        >✏️</Link>
        <button 
        @click="destroy(task.id)" 
        class="btn-delete"
        >🗑️</button>
    </div>
</template>

<script setup>
import dayjs from 'dayjs'

function formatDate(date) {
  return dayjs(date).format('DD/MM/YYYY')
}
</script>