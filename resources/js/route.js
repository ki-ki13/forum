import { createRouter, createWebHistory } from "vue-router";
import Threads from "./components/threads.vue";
import Login from "./layouts/login.vue";
import Register from "./layouts/register.vue";
import App from "./layouts/app.vue";

const routes = [
    {
        path: "/",
        component: App,
        children: [
            {
                path: "/threads",
                name: "threads",
                component: Threads,
            },
        ],
    },
    { path: "/login", component: Login },
    { path: "/register", component: Register },
];

const router = createRouter({
    history: createWebHistory("/forum"),
    routes,
});

export default router;
