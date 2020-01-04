import Vue from "vue";
import App from "./App";
import Buefy from "buefy";
import 'buefy/dist/buefy.css';
import router from "./router"
import store from "./store"
import VueCookie from 'vue-cookies';

Vue.use(Buefy)
Vue.use(VueCookie)

new Vue({
  components: { App },
  template: "<App/>",
  router,
  store
}).$mount("#app");