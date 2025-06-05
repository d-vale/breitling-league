<script setup>
import { RouterLink, useRoute } from "vue-router";
import { computed } from "vue";

const route = useRoute();

const isActive = computed(() => route.path === "/ranking");
</script>

<template>
    <RouterLink to="/ranking" class="nav-item" :class="{ active: isActive }">
        <svg
            width="22"
            height="22"
            viewBox="0 0 22 22"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M5.20013 7.99997H3.70016C3.03713 7.99997 2.40125 7.73658 1.93242 7.26774C1.46358 6.7989 1.2002 6.16302 1.2002 5.49998C1.2002 4.83694 1.46358 4.20106 1.93242 3.73222C2.40125 3.26338 3.03713 2.99999 3.70016 2.99999H5.20013M5.20013 7.99997V1H17.1999V7.99997M5.20013 7.99997C5.20013 9.59127 5.83226 11.1174 6.95747 12.2426C8.08267 13.3678 9.60877 14 11.2 14C12.7913 14 14.3174 13.3678 15.4426 12.2426C16.5678 11.1174 17.1999 9.59127 17.1999 7.99997M17.1999 7.99997H18.6999C19.363 7.99997 19.9988 7.73658 20.4677 7.26774C20.9365 6.7989 21.1999 6.16302 21.1999 5.49998C21.1999 4.83694 20.9365 4.20106 20.4677 3.73222C19.9988 3.26338 19.363 2.99999 18.6999 2.99999H17.1999M3.20016 20.9999H19.1999M9.20007 13.66V15.9999C9.20007 16.5499 8.73008 16.9799 8.23009 17.2099C7.0501 17.7499 6.20012 19.2399 6.20012 20.9999M13.2 13.66V15.9999C13.2 16.5499 13.67 16.9799 14.17 17.2099C15.35 17.7499 16.2 19.2399 16.2 20.9999"
                :stroke="isActive ? '#FFC107' : '#F5F5F5'"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
        <p>Ranking</p>
    </RouterLink>
</template>

<style scoped>
.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #F5F5F5;
    cursor: pointer;
    padding: 5px;
    opacity: 0.7;
    transition: opacity 0.2s, color 0.2s;
}

.nav-item.active {
    color: #FFC107;
    opacity: 1;
}

.nav-item.active p {
    color: #FFC107;
}

svg {
    width: 24px;
    height: 24px;
}

p {
    margin: 5px 0 0;
    font-size: 12px;
    transition: color 0.2s;
}
</style>
