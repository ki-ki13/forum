<template>
    <v-container>
        <v-row align="center" justify="center">
            <div class="d-flex justify-content-between w-100 mb-4">
                <v-text-field
                    v-model="search"
                    density="compact"
                    label="Search for forum question"
                    prepend-inner-icon="mdi-magnify"
                    variant="solo-filled"
                    flat
                    hide-details
                    single-line
                ></v-text-field>
            </div>
            <v-hover v-slot="{ isHovering, props }" v-for="item in filteredItems">
                <v-card
                    :to="'/thread/'+ item.id"
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
                                <div class="text-subtitle">
                                    {{ item.forum_user.nama }}
                                </div>
                                
                                <div class="text-h6 mb-1">
                                    {{ item.fq_question }}
                                </div>
                                <div class="text-overline">
                                    {{
                                        item.fq_group_id
                                            ? item.forum_group.g_nama
                                            : "general"
                                    }}
                                </div>
                            </div>
                            <div
                                class="w-100 keterangan d-flex flex-column align-end"
                            >
                                <div class="d-flex mb-4">
                                    <div
                                        class="chip-wrapper"
                                        v-for="cat in item.categories"
                                    >
                                        <v-chip
                                            class="ma-2 w-auto rounded-xl"
                                            color="primary"
                                            label
                                        >
                                            <small>{{ cat.c_nama }}</small>
                                        </v-chip>
                                    </div>
                                </div>

                                <div class="sub-keterangan d-flex">
                                    <div class="d-flex mr-4">
                                        <v-icon
                                            size="small"
                                            class="mr-2"
                                            icon="mdi-message"
                                        ></v-icon>
                                        <span class="text-caption">{{
                                            item.forum_detail_count
                                        }}</span>
                                    </div>
                                    <span class="text-caption"
                                        >Last Update :
                                        {{
                                            formatCreatedAt(item.updated_at)
                                        }}</span
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
import { onMounted, ref, watch } from "vue";
import { useUserStore } from "../store/user-store";
import { format } from "date-fns";
// import { useRoute, useRouter } from "vue-router";

const userStore = useUserStore();
const url = import.meta.env.VITE_API_URL;

let items = ref([]);
let filteredItems = ref([]);
let search = ref("");

function getData() {
    try {
        fetch(`${url}/forumq/${userStore.id}/user`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${userStore.api_token}`,
            },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                for (const i of data.data) items.value.push(i);
                filteredItems.value = items.value;
                console.log(items.value);
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

watch(search, (newValue, oldValue) => {
    filteredItems.value = items.value.filter((item) =>
        item.fq_question.toLowerCase().includes(newValue.toLowerCase())
    );
});

onMounted(() => {
    getData();
});
</script>
