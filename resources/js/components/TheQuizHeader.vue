<script setup>
const props = defineProps({
    previousUrl: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <router-link
        :to="props.previousUrl || '/'"
        class="back-button"
        v-if="props.previousUrl"
    >
        <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M18 6L6 18"
                stroke="#F5F5F5"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
            <path
                d="M6 6L18 18"
                stroke="#F5F5F5"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg> </router-link
    >>
</template>

<style scoped>
.back-button {
    display: flex;
    justify-content: left;
    align-items: center;
    width: 100%;
    height: 100%;
    padding: 25px;
}

svg {
    width: 24px;
    height: 24px;
}
</style>
