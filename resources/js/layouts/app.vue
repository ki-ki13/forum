<template>
    <v-layout class="rounded rounded-md">
        <v-app-bar :elevation="0">
            <template v-slot:prepend>
                <v-app-bar-nav-icon
                    variant="text"
                    @click.stop="drawer = !drawer"
                ></v-app-bar-nav-icon>
            </template>

            <v-app-bar-title><h3>Forum App</h3></v-app-bar-title>

            <template v-slot:append>
                <v-btn
                    :color="btnColor"
                    variant="outlined"
                    @click="toggleTheme"
                    class="mx-3"
                >
                    {{ btnText }}
                </v-btn>
                <v-menu>
                    <template v-slot:activator="{ props }">
                        <v-avatar color="primary">
                            <v-btn v-bind="props">
                                <span class="text-subtitle-2">{{
                                    user.initials
                                }}</span>
                            </v-btn>
                        </v-avatar>
                    </template>

                    <v-list>
                        <div class="mx-auto text-center pa-3">
                            <v-avatar color="primary" size="small">
                                <span class="text-subtitle-2">{{
                                    user.initials
                                }}</span>
                            </v-avatar>
                            <h3>{{ user.name }}</h3>
                            <p class="text-caption mt-1">{{ user.email }}</p>
                            <v-divider class="my-3"></v-divider>
                            <v-list-item
                                v-for="(item, i) in actionNavbar"
                                :key="i"
                                :value="item"
                                @click="handleClick(item)"
                            >
                                <template v-slot:prepend>
                                    <v-icon :icon="item.icon"></v-icon>
                                </template>

                                <v-list-item-title v-text="item.text">
                                </v-list-item-title>
                            </v-list-item>
                        </div>
                    </v-list>
                </v-menu>
            </template>
        </v-app-bar>

        <v-navigation-drawer class="pa-2" permanent v-model="drawer">
            <v-list>
                <v-list-item
                    v-for="(item, i) in menu"
                    :key="i"
                    :value="item"
                    color="primary"
                    rounded="xl"
                    :to="item.link"
                >
                    <template v-slot:prepend>
                        <v-icon :icon="item.icon"></v-icon>
                    </template>

                    <v-list-item-title v-text="item.text"></v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-main>
            <div style="min-height: 100dvh" class="main-content pa-4 d-flex">
                <router-view></router-view>
            </div>
            <v-footer>
                <p class="w-100 text-center">Made by QQ with 🌐</p>
            </v-footer>
        </v-main>
    </v-layout>
</template>
<script setup>
import { ref } from "vue";
import { useTheme } from "vuetify";
import { useUserStore } from "../store/user-store";
import { useThreadsStore } from "../store/threads-store";
import { useCommentsStore } from "../store/comments-store";
import { useRouter } from "vue-router";
const router = useRouter();
const userStore = useUserStore();
const threadsStore = useThreadsStore();
const commentsStore = useCommentsStore();
const btnColor = ref(undefined);
const btnText = ref("light");
const drawer = ref(true);
const actionNavbar = [
    {
        text: "Profile",
        icon: "mdi-account-circle",
        action: "to-profile",
    },
    { text: "Logout", icon: "mdi-logout", action: "logout" },
];

const user = {
    name: userStore.nama,
    initials: abbreviate(userStore.nama),
    email: userStore.username,
};

const menu = [
    { text: "Threads", icon: "mdi-forum", link: "/threads" },
    { text: "My threads", icon: "mdi-message", link: "/mythreads" },
    { text: "Group", icon: "mdi-account-multiple", link: "/group" },
];

const theme = useTheme();

function toggleTheme() {
    if (theme.global.current.value.dark) {
        theme.global.name.value = "light";
        btnColor.value = undefined;
        btnText.value = "dark";
    } else {
        theme.global.name.value = "dark";
        btnColor.value = "primary";
        btnText.value = "light";
    }
}

function abbreviate(word) {
    return word.charAt(0) + ".";
}

function handleClick(item) {
    if (item.action === "logout") {
        logout();
    } else if (item.action === "to-profile") {
        router.push("/profile");
    }
}

function logout() {
    userStore.clearUser();
    threadsStore.clearThreads();
    commentsStore.clearComments();
    router.push("/login");
}
</script>
