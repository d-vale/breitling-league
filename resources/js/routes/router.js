import { createRouter, createWebHistory } from "vue-router";

import HomePage from "../pages/HomePage.vue";
import BattlePage from "../pages/BattlePage.vue";
import ProfilePage from "../pages/ProfilePage.vue";
import QuestPage from "../pages/QuestPage.vue";
import RankingPage from "../pages/RankingPage.vue";

const routes = [
    { path: "/", component: HomePage },
    { path: "/profile", component: ProfilePage },
    { path: "/quest", component: QuestPage },
    { path: "/battle", component: BattlePage },
    { path: "/ranking", component: RankingPage },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
});
