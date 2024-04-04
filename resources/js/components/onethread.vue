<template>
    <v-container v-if="question">
        <v-row align="center" justify="center">
            <v-card class="mx-auto rounded-lg mb-3" width="100%">
                <v-card-item>
                    <div class="d-flex align-center ma-3">
                        <div class="img">
                            <v-avatar size="large" color="primary">
                                <span class="text-subtitle-2">
                                    {{
                                        abbreviate(
                                            question.forum_user
                                                ? question.forum_user.nama
                                                : "Undefined"
                                        )
                                    }}
                                </span>
                            </v-avatar>
                        </div>

                        <div class="text ml-3 w-100">
                            <div class="text-subtitle">
                                {{
                                    question.forum_user
                                        ? question.forum_user.nama
                                        : "undefined"
                                }}
                            </div>

                            <div class="text-h6 mb-1">
                                {{ question.fq_question }}
                            </div>
                            <!-- <div class="text-overline">
                                {{
                                    question.fq_group_id
                                        ? question.forum_group.g_nama
                                        : "general"
                                }}
                            </div> -->
                        </div>
                        <div
                            class="w-100 keterangan d-flex flex-column align-end"
                        >
                            <div class="d-flex mb-4">
                                <div
                                    class="chip-wrapper"
                                    v-for="cat in question.categories"
                                >
                                    <v-chip
                                        class="ma-2 w-auto rounded-xl"
                                        color="primary"
                                        label
                                    >
                                        <small>{{ cat.c_nama }}</small>
                                    </v-chip>
                                </div>
                            </div>

                            <div class="sub-keterangan d-flex">
                                <span class="text-caption"
                                    >Created at :
                                    {{
                                        question.created_at
                                            ? formatCreatedAt(
                                                  question.created_at
                                              )
                                            : ""
                                    }}</span
                                >
                            </div>
                            <v-menu>
                                <template v-slot:activator="{ props }">
                                    <v-btn
                                        icon="mdi-dots-horizontal"
                                        flat
                                        density="compact"
                                        v-bind="props"
                                    ></v-btn>
                                </template>

                                <v-list>
                                    <v-list-item
                                        v-for="(item, i) in cardAction"
                                        :key="i"
                                        :value="item"
                                        @click="
                                            handleAction(
                                                item,
                                                'card-utama',
                                                question.id
                                            )
                                        "
                                    >
                                        <v-list-item-title
                                            :class="'text-' + item.color"
                                            >{{ item.title }}</v-list-item-title
                                        >
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </div>
                    </div>
                </v-card-item>
            </v-card>
        </v-row>
        <v-row>
            <h6 class="text-h6">
                Replies -
                {{ question.forum_detail ? question.forum_detail.length : "" }}
            </h6>
        </v-row>
        <v-row align="center" justify="center" class="mb-4">
            <v-card
                v-for="item in reply"
                class="mx-auto rounded-lg mb-3"
                width="100%"
            >
                <v-card-item>
                    <div class="d-flex align-center ma-3">
                        <div class="img">
                            <v-avatar size="large" color="primary">
                                <span class="text-subtitle-2">
                                    {{
                                        abbreviate(item.forum_detail_user.nama)
                                    }}
                                </span>
                            </v-avatar>
                        </div>

                        <div class="text ml-3 w-100">
                            <div class="text-subtitle font-weight-bold">
                                {{ item.forum_detail_user.nama }}
                            </div>

                            <div
                                class="text-subtitle mb-1"
                                v-html="item.fd_detail"
                            ></div>
                        </div>
                        <div
                            class="w-100 keterangan d-flex flex-column align-end"
                        >
                            <div class="sub-keterangan d-flex">
                                <span class="text-caption"
                                    >Updated at :
                                    {{ formatCreatedAt(item.updated_at) }}</span
                                >
                            </div>
                            <v-menu>
                                <template v-slot:activator="{ props }">
                                    <v-btn
                                        icon="mdi-dots-horizontal"
                                        flat
                                        density="compact"
                                        v-bind="props"
                                    ></v-btn>
                                </template>

                                <v-list>
                                    <v-list-item
                                        v-for="(ca, i) in cardAction"
                                        :key="i"
                                        :value="ca"
                                        @click="
                                            handleAction(
                                                ca,
                                                'card-reply',
                                                item.id
                                            )
                                        "
                                    >
                                        <v-list-item-title
                                            :class="'text-' + ca.color"
                                            >{{ ca.title }}</v-list-item-title
                                        >
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </div>
                    </div>
                </v-card-item>
            </v-card>
        </v-row>
        <v-row class="mb-4">
            <div class="pb-4 d-flex w-100">
                <div style="height: fit-content" class="me-3">
                    <QuillEditor
                        ref="quill"
                        content-type="html"
                        v-model:content="fd_detail"
                        :toolbar="toolbarOptions"
                    />
                </div>
                <div>
                    <v-btn class="rounded" color="primary" @click="addReply"
                        >Send</v-btn
                    >
                </div>
            </div>
        </v-row>
    </v-container>

    <!-- dialogs -->
    <v-dialog v-model="deleteDialog" width="auto">
        <v-card
            max-width="400"
            text="Are you sure want to delete the data?"
            title="Delete confirmation"
        >
            <template v-slot:actions>
                <v-btn text="Close" @click="deleteDialog = false"></v-btn>
                <v-btn
                    class="ms-auto"
                    text="Yes"
                    color="red"
                    @click="handleDelete"
                ></v-btn>
            </template>
        </v-card>
    </v-dialog>

    <EditThread
        v-if="dataItem"
        :showModal="editDialog"
        @close="editDialog = false"
        :group="groups"
        :category="categories"
        :store="userStore"
        :data="dataItem"
        :onUpdate="getData"
    />
</template>
<script setup>
import { onMounted, ref } from "vue";
import { useUserStore } from "../store/user-store";
import { useRoute, useRouter } from "vue-router";
import { format } from "date-fns";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import EditThread from "../components/subcomponent/update-thread.vue";

let reply = ref([]);
let question = ref({});
const route = useRoute();
const router = useRouter();
const userStore = useUserStore();
const url = import.meta.env.VITE_API_URL;
const quill = ref(null);

let deleteDialog = ref(false);
let editDialog = ref(false);

let fd_detail = ref("");
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

function getData() {
    try {
        question.value = [];
        reply.value = [];
        fetch(`${url}/forumq/${route.params.id}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${userStore.api_token}`,
            },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                console.log(data.data);
                question.value = data.data;
                for (const i of question.value.forum_detail)
                    reply.value.push(i);
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    } catch (error) {
        console.log(error);
    }
}

function addReply() {
    // console.log(fd_detail.value)
    try {
        fetch(`${url}/forumd`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${userStore.api_token}`,
            },
            body: JSON.stringify({
                fd_forum_id: route.params.id,
                fd_detail: fd_detail.value,
                fd_user_id: userStore.id,
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
                getData();
                quill.value.setText("");
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    } catch (error) {
        console.log(error);
    }
}

const cardAction = [
    { title: "Update", color: undefined, action: "edit" },
    { title: "Delete", color: "red", action: "handleDelete" },
];

function getGroup() {
    try {
        fetch(`${url}/group`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${userStore.api_token}`,
            },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                for (const i of data.data) groups.value.push(i);
                groups.value.push({
                    id: "",
                    g_nama: "General",
                });
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    } catch (error) {
        console.log(error);
    }
}

function getCategory() {
    try {
        fetch(`${url}/category`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${userStore.api_token}`,
            },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                categories.value = data.data;
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    } catch (error) {
        console.log(error);
    }
}

let deleteId = ref(null);
let elementType = ref(null);
let groups = ref([]);
let categories = ref([]);
let dataItem = ref([]);

function handleAction(item, elementid, dataid) {
    if (item.action == "handleDelete") {
        deleteDialog.value = true;
        deleteId.value = dataid;
        elementType.value = elementid;
    } else {
        if (elementid == "card-utama") {
            const categoryIds = [];
            for (const category of question.value.categories) {
                categoryIds.push(category.id);
            }
            const newData = [];
            newData.push({
                id: question.value.id,
                fq_question: question.value.fq_question,
                group: question.value.fq_group_id,
                category: categoryIds,
            });
            dataItem.value = newData[0];
            editDialog.value = true;
        }
        console.log(dataItem.value);
    }
}

function handleDelete() {
    if (elementType.value === "card-utama") {
        deleteForum();
    } else {
        deleteReply();
    }
}

function deleteReply() {
    try {
        fetch(`${url}/forumd/${deleteId.value}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${userStore.api_token}`,
            },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                console.log(data);
                getData();
                deleteDialog.value = false;
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    } catch (error) {
        console.log(error);
    }
}

function deleteForum() {
    try {
        fetch(`${url}/forumq/${deleteId.value}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${userStore.api_token}`,
            },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                console.log(data);
                deleteDialog.value = false;
                router.back();
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    } catch (error) {
        console.log(error);
    }
}

const formatCreatedAt = (timestamp) => {
    return format(new Date(timestamp), "dd MMM yyyy HH:mm:ss");
};

function abbreviate(word) {
    return word.charAt(0) + ".";
}

onMounted(() => {
    getData();
    getGroup();
    getCategory();
});
</script>
