<script setup>
import { RouterView } from "vue-router";
</script>

<template>
    <RouterView></RouterView>
</template>

<style>
:root {
    background-color: #000000;
}

html,
body {
    background-color: #000000;
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
