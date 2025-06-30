<template>
  <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 flex items-start justify-center py-8">
    <div class="bg-white w-full max-w-6xl rounded-xl shadow-lg p-8">
      <h1 class="text-4xl font-bold text-gray-800 mb-6 text-center">
        Task Manager 🚀
      </h1>
      <div class="flex justify-center">
      <Link
        href="/tasks"
        class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg font-semibold text-lg text-center hover:bg-indigo-700 transition duration-300"
      >
        Go to Tasks!
      </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
