<template>
    <div class="pa-4 text-center">
        <v-dialog v-model="dialogVisible" max-width="400">
            <v-card>
                <v-card-title class="text-h6 text-primary">
                    Change Password
                </v-card-title>
                <v-card-text>
                    <v-row dense>
                        <v-col cols="12">
                            <v-text-field
                                label="Password"
                                v-model="password"
                                :append-inner-icon="
                                    visible ? 'mdi-eye-off' : 'mdi-eye'
                                "
                                :type="visible ? 'text' : 'password'"
                                @click:append-inner="visible = !visible"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <v-text-field
                                label="Confirm Password"
                                v-model="confirmPassword"
                                :append-inner-icon="
                                    visible ? 'mdi-eye-off' : 'mdi-eye'
                                "
                                :type="visible ? 'text' : 'password'"
                                @click:append-inner="visible = !visible"
                            ></v-text-field>
                            <small class="text-red" v-if="tidakSesuai">Password confirmation is incorrect</small>
                        </v-col>

                    </v-row>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        text="Close"
                        variant="plain"
                        @click="closeDialog"
                    ></v-btn>

                    <v-btn
                        color="primary"
                        text="Save"
                        variant="tonal"
                        @click="update"
                    ></v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script setup>
import { defineProps, ref, watch, defineEmits } from "vue";
const props = defineProps({
    showModal: {
        type: Boolean,
        default: false,
    },
    store:{Object}
});
const emit = defineEmits(['close']);
const dialogVisible = ref(props.showModal);
const visible = ref(false);
const password = ref(null)
const confirmPassword = ref(null)
const tidakSesuai = ref(false)

watch(
    () => props.showModal,
    (newValue) => {
        dialogVisible.value = newValue;
    }
);

const closeDialog = () => {
    dialogVisible.value = false;
    if (!dialogVisible.value) {
        emit("close");
    }
};

const url = import.meta.env.VITE_API_URL;

function update() {
    if(password.value != confirmPassword.value){
        tidakSesuai.value = true
    }
    try {
        fetch(`${url}/changepassword`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${props.store.api_token}`,
            },
            body: JSON.stringify({
                username: props.store.username,
                password: password.value,
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
                closeDialog();
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    } catch (error) {
        console.log(error);
    }
}
</script>
