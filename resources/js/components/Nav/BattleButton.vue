<script setup>
import { RouterLink, useRoute } from "vue-router";
import { computed } from "vue";

const route = useRoute();

const isActive = computed(() => route.path === "/battle");
</script>

<template>
    <RouterLink to="/battle" class="nav-item" :class="{ active: isActive }">
        <svg
            width="20"
            height="20"
            viewBox="0 0 20 20"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M12.7 15.4999L1.2002 3.99999V1H4.20015L15.7 12.5M11.2 16.9999L17.1999 11M14.2 14L18.1999 17.9999M17.1999 18.9999L19.1999 16.9999M12.7 4.49999L16.2 1H19.1999V3.99999L15.7 7.49998M3.20016 12L7.2001 15.9999M5.20013 14.9999L2.20018 17.9999M1.2002 16.9999L3.20016 18.9999"
                :stroke="isActive ? '#FFC107' : '#F5F5F5'"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
        <p class="battle">Battle</p>
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