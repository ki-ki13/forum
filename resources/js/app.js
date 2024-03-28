import './bootstrap';
import { createApp } from "vue";
import app from "./App.vue";
import  router  from "./route";
import vuetify from "./vuetify";


createApp(app).use(vuetify).use(router).mount("#app");