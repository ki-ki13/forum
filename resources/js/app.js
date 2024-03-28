import './bootstrap';
import { createApp } from "vue";
import app from "./layouts/app.vue";
import  router  from "./route";
import vuetify from "./vuetify";


createApp(app).use(vuetify).use(router).mount("#app");