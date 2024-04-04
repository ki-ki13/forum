<template>
    <div class="pa-4 text-center">
        <v-dialog v-model="dialogVisible" max-width="400">
            <v-card>
                <v-card-title class="text-h6 text-primary">
                    Update Question
                </v-card-title>
                <v-card-text>
                    <v-row dense>
                        <v-col cols="12">
                            <v-textarea
                                label="Question"
                                v-model="state.question"
                            ></v-textarea>
                        </v-col>

                        <v-col cols="12">
                            <v-select
                                label="Category"
                                v-model="state.category"
                                :items="category"
                                item-title="c_nama"
                                item-value="id"
                                chips
                                multiple
                            ></v-select>
                        </v-col>

                        <!-- <v-col cols="12">
                            <v-select
                                :items="group"
                                item-title="g_nama"
                                item-value="id"
                                label="Group"
                                v-model="state.group"
                            ></v-select>
                        </v-col> -->
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
    category: Object,
    group: Object,
    onUpdate: Function,
    store: Object,
    data: Object,
});
const emit = defineEmits(["close"]);
const dialogVisible = ref(props.showModal);

const itemModel = {
    question: props.data.fq_question,
    category: props.data.category,
    group: props.data.group ? props.data.group : "",
};

const state = reactive({
    ...itemModel,
});

const updateStateFromProps = () => {
    state.question = props.data.fq_question;
    state.category = props.data.category || [1];
    state.group = props.data.group || "";
};

watch(
    () => props.showModal,
    (newValue) => {
        dialogVisible.value = newValue;
        updateStateFromProps();
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
        fetch(`${url}/forumq/${props.data.id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${props.store.api_token}`,
            },
            body: JSON.stringify({
                fc_category_id: JSON.stringify(state.category),
                fq_question: state.question,
                fq_group_id: state.group,
                fq_created_by: props.store.id,
                fq_updated_by: props.store.id,
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
                props.onUpdate();
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
