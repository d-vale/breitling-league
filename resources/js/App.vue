<script setup>
import { RouterView } from "vue-router";
import TheNavBar from "./components/TheNavBar.vue";
import TheHeader from "./components/TheHeader.vue";
import { computed, ref, watch } from "vue";
import { useRoute } from "vue-router";
import TheQuizHeader from "./components/TheQuizHeader.vue";

const route = useRoute();
const previousUrl = ref(null);

const isQuiz = computed(() => {
    return route.path === "/quiz" || route.path === "/quiz/arena";
});

// Surveiller les changements de route pour capturer l'URL précédente
watch(
    () => route.path,
    (newPath, oldPath) => {
        // Si on navigue vers une page de quiz, sauvegarder l'ancienne route
        if ((newPath === "/quiz" || newPath === "/quiz/arena") && 
            oldPath && 
            oldPath !== "/quiz" && 
            oldPath !== "/quiz/arena") {
            previousUrl.value = oldPath;
        }
    }
);
</script>

<template>
    <div class="app-container">
        <header>
            <TheHeader v-if="!isQuiz" />
            <TheQuizHeader v-if="isQuiz" :previous-url="previousUrl" />
        </header>
        <main class="main-content">
            <RouterView></RouterView>
        </main>
        <footer class="footer-nav">
            <TheNavBar v-if="!isQuiz" />
        </footer>
    </div>
</template>

<style>
:root {
    background-color: var(--bg-default);
}

html,
body {
    margin: 0;
    padding: 0;
    background-color: var(--bg-default);
    overflow-x: hidden;
    height: 100%;
}

.app-container {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.main-content {
    flex: 1;
    overflow-y: auto;
    padding-bottom: 80px; /* Espace pour le footer */
}

.footer-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    z-index: 1000;
    background-color: var(--bg-default, #fff);
    border-top: 1px solid var(--border-color, #e5e7eb);
}

/* Hide scrollbar for Chrome, Safari and Opera */
::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
* {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}

/* Assurer que le contenu peut scroller */
body {
    overflow-y: auto !important;
}

/* Style pour éviter que le contenu soit coupé */
@media (max-width: 768px) {
    .main-content {
        padding-bottom: 100px; /* Plus d'espace sur mobile */
    }
}
</style>