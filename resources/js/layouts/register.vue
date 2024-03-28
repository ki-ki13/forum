<template>
    <v-layout class="rounded rounded-md">
        <v-app-bar :elevation="0">
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
            </template>
        </v-app-bar>
        <v-main>
            <div style="min-height: 100dvh" class="main-content pa-4 d-flex">
                <div class="ma-auto w-100">
                    <v-card
                        class="mx-auto pa-12 pb-8"
                        elevation="8"
                        max-width="448"
                        rounded="lg"
                    >
                        <div class="text-h5 text-medium-emphasis text-center">
                            Register
                        </div>
                        <div class="text-subtitle-1 text-medium-emphasis">
                            Username
                        </div>

                        <v-text-field
                            density="compact"
                            placeholder="Username"
                            prepend-inner-icon="mdi-account"
                            variant="outlined"
                            v-model="username"
                        ></v-text-field>

                        <div
                            class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
                        >
                            Password
                        </div>

                        <v-text-field
                            :append-inner-icon="
                                visible ? 'mdi-eye-off' : 'mdi-eye'
                            "
                            :type="visible ? 'text' : 'password'"
                            density="compact"
                            placeholder="Enter your password"
                            prepend-inner-icon="mdi-lock-outline"
                            variant="outlined"
                            v-model="password"
                            @click:append-inner="visible = !visible"
                        ></v-text-field>

                        <div
                            class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
                        >
                            Nama
                        </div>
                        <v-text-field
                            density="compact"
                            placeholder="Nama"
                            prepend-inner-icon="mdi-account"
                            variant="outlined"
                            v-model="nama"
                        ></v-text-field>

                        <div
                            class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
                        >
                            Alamat
                        </div>
                        <v-textarea
                            density="compact"
                            placeholder="Alamat"
                            prepend-inner-icon="mdi-home-map-marker"
                            variant="outlined"
                            v-model="alamat"
                        ></v-textarea>

                        <div
                            class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
                        >
                            No Telepon
                        </div>
                        <v-text-field
                            density="compact"
                            placeholder="No Telepon"
                            prepend-inner-icon="mdi-cellphone"
                            variant="outlined"
                            v-model="no_telp"
                        ></v-text-field>

                        <div
                            class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
                        >
                            Jenis Kelamin
                        </div>
                        <v-select
                            :items="jenkel"
                            v-model="jenis_kelamin"
                            prepend-inner-icon="mdi-account"
                            density="compact"
                        ></v-select>

                        <v-btn
                            block
                            class="mb-8"
                            color="blue"
                            size="large"
                            variant="tonal"
                            @click="register"
                        >
                            Register
                        </v-btn>
                        <v-card-text class="text-center">
                            Already have an account?
                            <router-link
                                class="text-blue text-decoration-none"
                                to="/login"
                                rel="noopener noreferrer"
                            >
                                Login
                                <v-icon icon="mdi-chevron-right"></v-icon>
                            </router-link>
                        </v-card-text>
                    </v-card>
                </div>
            </div>
        </v-main>
    </v-layout>
</template>
<script setup>
import { ref } from "vue";
import { useTheme } from "vuetify";

const visible = ref(false);
const btnColor = ref(undefined);
const btnText = ref("dark theme");
const theme = useTheme();

function toggleTheme() {
    if (theme.global.current.value.dark) {
        theme.global.name.value = "light";
        btnColor.value = undefined;
        btnText.value = "dark theme";
    } else {
        theme.global.name.value = "dark";
        btnColor.value = "primary";
        btnText.value = "light theme";
    }
}

let username = ref(null);
let password = ref(null);
let nama = ref(null);
let alamat = ref(null);
let no_telp = ref(null);
let jenis_kelamin = ref("laki-laki");

const jenkel = ["laki-laki", "perempuan"];
const url = import.meta.env.VITE_API_URL;
function register() {
    try {
        fetch(`${url}/auth/register`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                username: username.value,
                password: password.value,
                nama: nama.value,
                alamat: alamat.value,
                no_telp: no_telp.value,
                jenis_kelamin: jenis_kelamin.value,
                role:"User"
            }),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                console.log(data);
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    } catch (error) {
        console.log(error);
    }
}
</script>
