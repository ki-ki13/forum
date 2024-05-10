import { createRouter, createWebHistory } from "vue-router";
import Threads from "./components/threads.vue";
import Onethreads from "./components/onethread.vue";
import Mapel from "./components/mapel.vue";
import Mythreads from "./components/mythreads.vue";
import Profile from "./components/profile.vue";
import Login from "./layouts/login.vue";
import Register from "./layouts/register.vue";
import App from "./layouts/app.vue";
import { useUserStore } from "./store/user-store";

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
            {
                path: "/thread/:id",
                name: "onethreads",
                component: Onethreads,
            },
            {
                path: "/mythreads",
                name: "mythreads",
                component: Mythreads,
            },
            {
                path: "/profile",
                name: "profile",
                component: Profile,
            },
            {
                path: "/mapel",
                name: "Mapel",
                component: Mapel,
            },
        ],
    },
    { path: "/login", component: Login },
    { path: "/register", component: Register },
];

const router = createRouter({
    history: createWebHistory("/app_forum"),
    routes,
});

router.beforeEach((to, from, next) => {
    console.log(to.path)
    const publicPages = ["/login", "/register"];
    const authRequired = !publicPages.includes(to.path);
    const api_token = useUserStore().api_token;
    if (authRequired && !api_token ) {
        next({ path: "/login" });
    } else {
        if(to.path ==="/"){
            next({path:"/threads"})
        }
        next();
    }
});
export default router;
