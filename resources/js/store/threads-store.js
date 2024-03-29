import { defineStore } from "pinia";
import { useUserStore } from "./user-store";

const url = import.meta.env.VITE_API_URL;

export const useThreadsStore = defineStore("threads", {
    state: () => ({
        threads: [],
        threadsCount: null,
    }),

    actions: {
        async setThreads() {
            fetch(`${url}/forumq/${useUserStore().id}/user`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${useUserStore().api_token}`
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    console.log(data);
                    this.$state.threads = data.data;
                    this.$state.threadsCount = data.data.length;
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        },
        clearThreads() {
            this.$state.threads = null;
            this.$state.threadsCount = null;
        },
    },
    persist: true,
});
