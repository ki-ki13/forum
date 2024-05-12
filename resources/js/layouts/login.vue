<template>
    <v-layout class="rounded rounded-md">
        <v-app-bar :elevation="0">
            <v-app-bar-title><h3>Smart Insight</h3></v-app-bar-title>

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
                    <v-alert
                        :text="alertSalahPesan"
                        :title="alertSalahTitle"
                        type="error"
                        variant="tonal"
                        class="w-50 mx-auto my-3"
                        v-if="alertSalah"
                    ></v-alert>
                    <v-form v-on:submit.prevent="login">
                        <v-card
                            class="mx-auto pa-12 pb-8"
                            elevation="8"
                            max-width="448"
                            rounded="lg"
                        >
                            <div
                                class="text-h5 text-medium-emphasis text-center"
                            >
                                Login
                            </div>
                            <div class="text-subtitle-1 text-medium-emphasis">
                                Username
                            </div>

                            <v-text-field
                                density="compact"
                                placeholder="Username"
                                prepend-inner-icon="mdi-account"
                                variant="outlined"
                                v-model="state.username"
                                :error-messages="
                                    v$.username.$errors.map((e) => e.$message)
                                "
                                required
                                @blur="v$.username.$touch"
                                @input="v$.username.$touch"
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
                                v-model="state.password"
                                :error-messages="
                                    v$.password.$errors.map((e) => e.$message)
                                "
                                required
                                @blur="v$.password.$touch"
                                @input="v$.password.$touch"
                                @click:append-inner="visible = !visible"
                            ></v-text-field>

                            <v-btn
                                block
                                class="mb-8"
                                color="blue"
                                size="large"
                                variant="tonal"
                                type="submit"
                            >
                                Log In
                            </v-btn>

                            <v-card-text class="text-center">
                                <router-link
                                    class="text-blue text-decoration-none"
                                    to="/register"
                                    rel="noopener noreferrer"
                                >
                                    Sign up now
                                    <v-icon icon="mdi-chevron-right"></v-icon>
                                </router-link>
                            </v-card-text>
                        </v-card>
                    </v-form>
                </div>
            </div>
        </v-main>
    </v-layout>
</template>
<script setup>
import { ref, reactive } from "vue";
import { useTheme } from "vuetify";
import { required } from "@vuelidate/validators";
import { useVuelidate } from "@vuelidate/core";
import { useRouter } from "vue-router";
import { useUserStore } from "../store/user-store";
const url = import.meta.env.VITE_API_URL;
const userStore = useUserStore();

const router = useRouter();
const visible = ref(false);
const btnColor = ref(undefined);
const btnText = ref("light");
const alertSalah = ref(false);
const alertSalahTitle = ref(false);
const alertSalahPesan = ref(false);

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
const initialState = {
    username: "",
    password: "",
};

const state = reactive({
    ...initialState,
});

const rules = {
    username: { required },
    password: { required },
};

const v$ = useVuelidate(rules, state);

function login() {
    try {
        const check = v$.value.$invalid;
        if (check) {
            alertSalahTitle.value = "Kolom kosong";
            alertSalahPesan.value = "Silakan isi semua kolom 😊";
            alertSalah.value = true;
        }
        fetch(`${url}/auth/checkLogin`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                username: state.username,
                password: state.password,
            }),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                if (data.success == false) {
                    alertSalahTitle.value = "Password atau Username salah";
                    alertSalahPesan.value =
                        "Silakan isi username dan password dengan benar 😊";
                    alertSalah.value = true;
                    // alert("username atau password salah");
                }
                console.log(data.data);
                userStore.setUserDetails(data.data[0]);
                
                router.push("/threads");
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    } catch (error) {
        console.log(error);
    }
}
</script>
