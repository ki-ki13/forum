import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
    state: () => ({
      id: null,
      role: null,
      api_token: null,
      username: null,
      nama: null,
      alamat: null,
      jenis_kelamin: null,
      no_telp: null,
    }),
  
    actions: {
        async setUserDetails(res) {
            this.$state.id = res.id;
            this.$state.role = res.role;
            this.$state.api_token = res.api_token;
            this.$state.username = res.username;
            this.$state.nama = res.nama;
            this.$state.alamat = res.alamat;
            this.$state.jenis_kelamin = res.jenis_kelamin;
            this.$state.no_telp = res.no_telp
          },
          clearUser() {
            this.$state.id = null;
            this.$state.role = null;
            this.$state.api_token = null;
            this.$state.username = null;
            this.$state.nama = null;
            this.$state.alamat = null;
            this.$state.jenis_kelamin = null;
            this.$state.no_telp = null;
          }
    },
    persist: true,
})