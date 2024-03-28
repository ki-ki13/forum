import { createRouter, createWebHistory } from 'vue-router';
import Threads from "./components/threads.vue";

const routes = [
    { path: '/', component: Threads },
];

const router = createRouter({
    history: createWebHistory('/forum'),
    routes: routes
});

export default router;
