import Vue from "vue";
import VueRouter from "vue-router";
import CreateElection from "../components/CreateElection";
import Vote from "../components/Vote";

Vue.use(VueRouter);

export default new VueRouter({
  mode: "history",
  routes: [
    { path: "/", component: CreateElection },
    { path: "/vote/:hash", component: Vote, name: 'Vote' },
    { path: "*", redirect: "/" }
  ]
});