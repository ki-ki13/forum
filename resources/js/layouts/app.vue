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
                <v-btn @click="toggleTheme" class="mx-3">light theme</v-btn>
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
                            <v-avatar color="primary" size="large">
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
                >
                    <template v-slot:prepend>
                        <v-icon :icon="item.icon"></v-icon>
                    </template>

                    <v-list-item-title v-text="item.text"></v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-main>
            <div style="min-height: 100dvh" class="main-content pa-4">
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
import { useTheme } from 'vuetify'

const drawer = ref(true);
const actionNavbar = [
    { text: "Profile", icon: "mdi-account-circle" },
    { text: "Logout", icon: "mdi-logout" },
];
const user = {
    name: "Kiki",
    initials: "QQ",
    email: "rizkimah@gmail.com",
};

const menu = [
    { text: "Threads", icon: "mdi-forum" },
    { text: "My threads", icon: "mdi-message" },
    { text: "Group", icon: "mdi-account-multiple" },
];

const theme = useTheme()

function toggleTheme () {
  theme.global.name.value = theme.global.current.value.dark ? 'light' : 'dark'
}

</script>
