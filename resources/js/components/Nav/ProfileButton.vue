<script setup>
import { RouterLink, useRoute } from "vue-router";
import { computed } from "vue";

const route = useRoute();

const isActive = computed(() => route.path === "/profile");
</script>

<template>
    <RouterLink to="/profile" class="nav-item" :class="{ active: isActive }">
        <svg
            width="18"
            height="20"
            viewBox="0 0 18 20"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M9.20007 11C11.9615 11 14.2 8.7614 14.2 5.99998C14.2 3.23857 11.9615 1 9.20007 1C6.43869 1 4.20015 3.23857 4.20015 5.99998C4.20015 8.7614 6.43869 11 9.20007 11ZM9.20007 11C11.3218 11 13.3566 11.8428 14.8568 13.3431C16.3571 14.8434 17.1999 16.8782 17.1999 18.9999M9.20007 11C7.07837 11 5.04357 11.8428 3.5433 13.3431C2.04304 14.8434 1.2002 16.8782 1.2002 18.9999"
                :stroke="isActive ? '#FFC107' : '#F5F5F5'"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
        <p>Profile</p>
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
