<template>
    <div class="wrapper w-100">
        <h5 class="text-h5 ma-2">My Profile</h5>
        <div class="w-100 d-flex flex-wrap">
            <div class="account flex-fill">
                <v-card variant="outlined" color="primary" class="pa-2 ma-2">
                    <div class="d-flex align-start">
                        <div class="avatar my-4 ms-4">
                            <v-avatar color="primary" size="x-large">
                                <span class="text-subtitle-2">{{
                                    abbreviate(userStore.nama)
                                }}</span>
                            </v-avatar>
                        </div>
                        <div class="content w-100">
                            <div
                                class="atas w-100 d-flex justify-space-between flex-sm-row flex-column"
                            >
                                <v-card-title class="text-h5">
                                    {{ userStore.nama }}
                                </v-card-title>
                                <v-btn
                                    color="primary"
                                    class="float-end ma-1"
                                    variant="tonal"
                                    @click="showChangePassModal = true"
                                >
                                    Change Password
                                </v-btn>
                            </div>

                            <v-list lines="one" class="mb-3" style="background: transparent">
                                <v-list-item
                                    v-for="(item, i) in items"
                                    :key="i"
                                    :title="item.text"
                                    :subtitle="item.subtext"
                                >
                                    <template v-slot:prepend>
                                        <v-icon
                                            :icon="item.icon"
                                            color="primary"
                                        />
                                    </template>
                                </v-list-item>
                            </v-list>

                            <v-card-actions class="d-flex justify-end">
                                <v-btn
                                    variant="text"
                                    @click.stop="showEditModal = true"
                                >
                                    Edit Profile
                                </v-btn>
                            </v-card-actions>
                        </div>
                    </div>
                </v-card>
            </div>
            <div class="password flex-fill">
                <v-card variant="tonal" color="primary" class="pa-2 ma-2">
                    <v-card-title class="text-h5"> Threads Stats </v-card-title>

                    <v-img
                        class="my-4 mx-auto"
                        :src="app_url + '/public/assets/img/OBJECTS.png'"
                        width="210"
                    ></v-img>
                    <div class="d-flex justify-center mb-3">
                        <div class="wrapper rounded-pill px-4 py-3 d-flex elevation-6" :class="useTheme().global.current.value.dark?'bg-blue-grey-darken-4':'bg-primary'">
                            <div class="d-flex flex-column align-center">
                                <span class="px-2 py-1 text-white font-weight-bold">My Threads</span>
                                <span>{{ threadsStore.threadsCount }}</span>
                            </div>
                            <v-divider vertical :thickness="2" class="border-opacity-50"/>
                            <div class="d-flex flex-column align-center">
                                <span class="px-2 py-1 text-white font-weight-bold">My Comments</span>
                                <span>{{commentStore.commentsCount}}</span>
                            </div>
                            <!-- <v-divider vertical :thickness="2" class="border-opacity-50"/>
                            <div class="d-flex flex-column align-center">
                                <span class="px-2 py-1 text-white font-weight-bold">My Groups</span>
                                <span class="text-blue-grey-lighten-2">comming soon</span>
                            </div> -->
                        </div>
                    </div>
                </v-card>
            </div>
        </div>
    </div>
    <EditModal
        :showModal="showEditModal"
        @close="showEditModal = false"
        :store="userStore"
        :onUpdate="updateListener"
    />
    <ChangePassModal
        :showModal="showChangePassModal"
        :store="userStore"
        @close="showChangePassModal = false"
    />
</template>
<script setup>
import { ref, onMounted } from "vue";
import { useUserStore } from "../store/user-store";
import { useThreadsStore } from "../store/threads-store";
import { useCommentsStore } from "../store/comments-store";
import EditModal from "../components/subcomponent/profile-modal.vue";
import ChangePassModal from "../components/subcomponent/change-pass.vue";
import { useTheme } from "vuetify/lib/framework.mjs";

const app_url = import.meta.env.VITE_APP_URL;

const userStore = useUserStore();
const threadsStore = useThreadsStore();
const commentStore = useCommentsStore();
const showEditModal = ref(false);
const showChangePassModal = ref(false);
const items = ref();

function abbreviate(word) {
    return word.charAt(0) + ".";
}
function getItems() {
    const items = [
        { text: "Username", subtext: userStore.username, icon: "mdi-account" },
        { text: "Phone", subtext: userStore.no_telp, icon: "mdi-cellphone" },
        { text: "Gender", subtext: userStore.jenis_kelamin, icon: "mdi-flag" },
        { text: "Alamat", subtext: userStore.alamat, icon: "mdi-home" },
    ];
    return items;
}

const updateUser = () => {
    items.value = getItems();
};

const updateListener = () => updateUser();

onMounted(() => {
    items.value = getItems();
});
</script>
