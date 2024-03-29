import { defineStore } from "pinia";
import { useUserStore } from "./user-store";

const url = import.meta.env.VITE_API_URL;

export const useCommentsStore = defineStore("comments", {
    state: () => ({
        comments: [],
        commentsCount: null,
    }),

    actions: {
        async setComments() {
            fetch(`${url}/forumd/${useUserStore().id}/user`, {
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
                    this.$state.comments = data.data;
                    this.$state.commentsCount = data.data.length;
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        },
        clearComments() {
            this.$state.comments = null;
            this.$state.commentsCount = null;
        },
    },
    persist: true,
});
