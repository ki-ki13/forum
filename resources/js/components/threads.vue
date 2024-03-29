<template>
    <v-container>
        <v-row align="center" justify="center">
            <v-hover v-slot="{ isHovering, props }">
                <v-card
                    v-for="item in items"
                    :variant="isHovering ? 'tonal' : 'elevated'"
                    class="mx-auto rounded-lg mb-3"
                    width="100%"
                    v-bind="props"
                    :color="isHovering ? 'primary' : undefined"
                >
                    <v-card-item>
                        <div class="d-flex align-center ma-3">
                            <div class="img">
                                <v-avatar size="large" color="primary">
                                    <span class="text-subtitle-2">
                                        {{ abbreviate(item.forum_user.nama) }}
                                    </span>
                                </v-avatar>
                            </div>

                            <div class="text ml-3 w-100">
                                <div class="text-overline">
                                    {{ item.fq_group_id? item.forum_group.g_nama: "general" }}
                                </div>
                                <div class="text-h6 mb-1">{{ item.fq_question }}</div>
                                <div class="text-subtitle">{{ item.forum_user.nama }}</div>
                            </div>
                            <div
                                class="w-100 keterangan d-flex flex-column align-end"
                            >
                                <div class="chip-wrapper mb-4">
                                    <v-chip
                                        class="ma-2 w-auto"
                                        color="primary"
                                        label
                                    >
                                        Category
                                    </v-chip>
                                </div>
                                <div class="sub-keterangan d-flex">
                                    <div class="d-flex mr-4">
                                        <v-icon
                                            size="small"
                                            class="mr-2"
                                            icon="mdi-message"
                                        ></v-icon>
                                        <span class="text-caption">10</span>
                                    </div>
                                    <span class="text-caption"
                                        >Last Update : {{item.updated_at}}</span
                                    >
                                </div>
                            </div>
                        </div>
                    </v-card-item>
                </v-card>
            </v-hover>
        </v-row>
    </v-container>
</template>
<script setup>
import { onMounted } from "vue";
import { useUserStore } from "../store/user-store";
import { format } from "date-fns";
// import { useRoute, useRouter } from "vue-router";

const userStore = useUserStore();
const url = import.meta.env.VITE_API_URL;

let items = []

function getData() {
    try {
        fetch(`${url}/forumq`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${userStore.api_token}`,
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
                for(const i of data.data) items.push(i)
                console.log(items)
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    } catch (error) {
        console.log(error);
    }
}

const formatCreatedAt = (timestamp) => {
    return format(new Date(timestamp), "dd MMM yyyy HH:mm:ss");
  };

function abbreviate(word) {
    return word.charAt(0) + ".";
}

onMounted(() => {
    getData();
});
</script>
