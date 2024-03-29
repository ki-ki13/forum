import './bootstrap';
import { createApp } from "vue";
import app from "./App.vue";
import  router  from "./route";
import vuetify from "./vuetify";
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)


createApp(app).use(vuetify).use(router).use(pinia).mount("#app");