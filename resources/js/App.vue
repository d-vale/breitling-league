<script setup>
import { RouterView } from "vue-router";


</script>

<template>
    <RouterView></RouterView>
</template>

<style>

:root {
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

.bg-bg-default {
    background-color: var(--bg-default);
}

/* Hide scrollbar for IE, Edge and Firefox */
* {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}
</style>
