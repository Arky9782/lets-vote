import Vue from "vue";
import Vuex from "vuex";
import ElectionModule from "./election";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    election: ElectionModule
  }
});