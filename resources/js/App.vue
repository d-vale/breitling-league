<script setup>
import { RouterView } from "vue-router";
import TheNavBar from "./components/TheNavBar.vue";
import TheHeader from "./components/TheHeader.vue";
</script>


<template>
    <header>
        <TheHeader />
    </header>
    <main>
        <RouterView></RouterView>
    </main>
    <footer><TheNavBar /></footer>
</template>

<style>
:root{
    background-color: var(--bg-default);
}

html,
body {
    background-color: var(--bg-default);
    overflow-x: hidden;
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
</style>
