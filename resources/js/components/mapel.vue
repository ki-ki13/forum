<template>
    <v-container>
      <v-row align="center" justify="center">
        <div class="d-flex justify-content-between w-100 mb-4">
          <h5 class="text-h4">Mata Pelajaran</h5>
        </div>
      </v-row>
      <v-row align="center" justify="center">
        <v-data-table :items="items" :headers="headers" item-key="id"></v-data-table>
      </v-row>
    </v-container>
  </template>
  
  <script setup>
  import { onMounted, ref } from "vue";
  import { useUserStore } from "../store/user-store";
  
  const userStore = useUserStore();
  const url = import.meta.env.VITE_API_URL;
  
  let items = ref([]);
  const headers = [
    { title: "No", value: "id" },
    { title: "Nama", value: "name" }
  ];
  
  function getData() {
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
          items.value = data.data.map(item => ({ id: item.id, name: item.c_nama }));
          console.log(items.value);
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    } catch (error) {
      console.log(error);
    }
  }
  
  onMounted(() => {
    getData();
  });
  </script>
  