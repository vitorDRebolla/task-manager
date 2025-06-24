import { defineStore } from 'pinia';
import axios from 'axios';

export const useTaskStore = defineStore('task', {
  state: () => ({
    tasks: [],
  }),
  actions: {
    async fetchTasks() {
      const response = await axios.get('/tasks');
      this.tasks = response.data.data;
    },
  },
});