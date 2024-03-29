<template>
    <div class="pa-4 text-center">
        <v-dialog v-model="dialogVisible" max-width="400">
            <v-card>
                <v-card-title class="text-h6 text-primary">
                    User Profile
                </v-card-title>
                <v-card-text>
                    <v-row dense>
                        <v-col cols="12">
                            <v-text-field
                                label="Nama"
                                v-model="state.nama"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <v-text-field
                                label="Phone"
                                v-model="state.no_telp"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <v-select
                                :items="['Laki-laki', 'Perempuan']"
                                label="Gender"
                                v-model="state.jenis_kelamin"
                            ></v-select>
                        </v-col>

                        <v-col cols="12">
                            <v-textarea
                                label="Alamat"
                                v-model="state.alamat"
                            ></v-textarea>
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
import { reactive } from "vue";
import { defineProps, ref, watch, defineEmits } from "vue";
const props = defineProps({
    showModal: {
        type: Boolean,
        default: false,
    },
    store: Object,
    onUpdate :Function
});
const emit = defineEmits(['close']);
const dialogVisible = ref(props.showModal);

const itemModel = {
    nama: props.store.nama,
    alamat: props.store.alamat,
    jenis_kelamin: props.store.jenis_kelamin,
    no_telp: props.store.no_telp,
};

const state = reactive({
    ...itemModel,
});

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
    try {
        fetch(`${url}/user/${props.store.id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${props.store.api_token}`,
            },
            body: JSON.stringify({
                nama: state.nama,
                alamat: state.alamat,
                no_telp: state.no_telp,
                jenis_kelamin: state.jenis_kelamin,
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
                props.store.setUserDetails(data.data)
                props.onUpdate()
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
