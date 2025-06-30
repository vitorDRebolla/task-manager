<template>
    <nav v-if="links.length" class="flex items-center space-x-2">
      <button
        v-for="link in links"
        :key="link.label"
        v-html="link.label"
        :disabled="!link.url"
        @click="go(link.url)"
        class="px-3 py-1 border rounded disabled:opacity-50"
      />
    </nav>
  </template>
  
  <script setup>
  import { defineProps } from 'vue'
  import { Inertia } from '@inertiajs/inertia'
  
  const props = defineProps({
    links: {
      type: Array,
      default: () => [],
    },
  })
  
  function go(url) {
    Inertia.get(url, {}, { preserveState: true, replace: true })
  }
  </script>
  