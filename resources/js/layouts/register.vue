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
                    <v-form v-on:submit.prevent="register">
                        <v-card
                            class="mx-auto pa-12 pb-8"
                            elevation="8"
                            max-width="448"
                            rounded="lg"
                        >
                            <div
                                class="text-h5 text-medium-emphasis text-center"
                            >
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
                                v-model="state.nama"
                                :error-messages="
                                    v$.nama.$errors.map((e) => e.$message)
                                "
                                required
                                @blur="v$.nama.$touch"
                                @input="v$.nama.$touch"
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
                                v-model="state.alamat"
                                :error-messages="
                                    v$.alamat.$errors.map((e) => e.$message)
                                "
                                required
                                @blur="v$.alamat.$touch"
                                @input="v$.alamat.$touch"
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
                                v-model="state.no_telp"
                                :error-messages="
                                    v$.no_telp.$errors.map((e) => e.$message)
                                "
                                required
                                @blur="v$.no_telp.$touch"
                                @input="v$.no_telp.$touch"
                            ></v-text-field>

                            <div
                                class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
                            >
                                Jenis Kelamin
                            </div>
                            <v-select
                                :items="jenkel"
                                v-model="state.jenis_kelamin"
                                prepend-inner-icon="mdi-account"
                                density="compact"
                                :error-messages="
                                    v$.jenis_kelamin.$errors.map((e) => e.$message)
                                "
                                required
                                @blur="v$.jenis_kelamin.$touch"
                                @input="v$.jenis_kelamin.$touch"
                            ></v-select>

                            <v-btn
                                block
                                class="mb-8"
                                color="blue"
                                size="large"
                                variant="tonal"
                                type="submit"
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
import { useRouter } from 'vue-router'

const router = useRouter()
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
    nama: "",
    alamat: "",
    no_telp: "",
    jenis_kelamin: "laki-laki",
};

const state = reactive({
    ...initialState,
});

const rules = {
    username: { required },
    password: { required },
    nama: { required },
    alamat: { required },
    no_telp: { required },
    jenis_kelamin: { required },
};

const v$ = useVuelidate(rules, state);

const jenkel = ["laki-laki", "perempuan"];
const url = import.meta.env.VITE_API_URL;
function register() {
    try {
        const check = v$.value.$invalid;
        if (check) {
            alertSalahTitle.value = "Kolom kosong";
            alertSalahPesan.value = "Silakan isi semua kolom 😊";
            alertSalah.value = true;
            window.scrollTo(0,0)
        }
        fetch(`${url}/auth/register`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                username: state.username,
                password: state.password,
                nama: state.nama,
                alamat: state.alamat,
                no_telp: state.no_telp,
                jenis_kelamin: state.jenis_kelamin,
                role: "User",
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
                router.push('/login')
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    } catch (error) {
        console.log(error);
    }
}
</script>
