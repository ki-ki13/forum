<template>
    <div class="pa-4 text-center">
        <v-dialog v-model="dialogVisible" max-width="400">
            <v-card>
                <v-card-title class="text-h6 text-primary">
                    Edit Reply
                </v-card-title>
                <v-card-text>
                    <v-row dense>
                        <v-col cols="12">
                            <div style="height: fit-content" class="me-3">
                                <QuillEditor
                                    ref="quill"
                                    content-type="html"
                                    v-model:content="state.reply"
                                    :toolbar="toolbarOptions"
                                />
                            </div>
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
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

const toolbarOptions = [
    ["bold", "italic", "underline", "strike"], // toggled buttons
    ["blockquote", "code-block"],
    ["link", "formula"],

    [{ header: 1 }, { header: 2 }], // custom button values
    [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
    [{ script: "sub" }, { script: "super" }], // superscript/subscript
    [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
    [{ direction: "rtl" }], // text direction

    [{ color: [] }, { background: [] }], // dropdown with defaults from theme
    [{ font: [] }],
    [{ align: [] }],

    ["clean"], // remove formatting button
];

const props = defineProps({
    showModal: {
        type: Boolean,
        default: false,
    },
    onUpdate: Function,
    store: Object,
    data: Object,
});
const emit = defineEmits(["close"]);
const dialogVisible = ref(props.showModal);

const itemModel = {
    reply: props.data.fd_detail
};

const state = reactive({
    ...itemModel,
});

const updateStateFromProps = () => {
    state.reply= props.data.fd_detail
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
        fetch(`${url}/forumd/${props.data.id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${props.store.api_token}`,
            },
            body: JSON.stringify({
                fd_forum_id : props.data.fd_forum_id,
                fd_detail : state.reply,
                fd_user_id: props.store.id
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