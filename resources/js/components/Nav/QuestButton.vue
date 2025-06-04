<script setup>
import { ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import questSvg from "../assets/navbar-icons/quest-icon.svg"; // Ajustez le chemin selon votre structure

const router = useRouter();
const route = useRoute();

const isActive = ref(route.name === "quest");

const goToQuest = () => {
    router.push({ name: "quest" });
};
</script>

<template>
    <div class="nav-item" @click="goToQuest" :class="{ active: false }">
        <svg
            width="18"
            height="22"
            viewBox="0 0 18 22"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M1.2002 14C1.2002 14 2.20018 13 5.20013 13C8.20009 13 10.2001 14.9999 13.2 14.9999C16.2 14.9999 17.1999 14 17.1999 14V2C17.1999 2 16.2 2.99999 13.2 2.99999C10.2001 2.99999 8.20009 1 5.20013 1C2.20018 1 1.2002 2 1.2002 2V14ZM1.2002 14V20.9999"
                :stroke="isActive ? '#FFC107' : '#F5F5F5'"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
        <p>Quest</p>
    </div>
</template>

<style scoped>
.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: white;
    cursor: pointer;
    padding: 5px;
    opacity: 0.7;
    transition: opacity 0.2s;
}

.nav-item:hover {
    opacity: 1;
}

.nav-item.active {
    color: #ffc107;
    opacity: 1;
}

svg {
    width: 24px;
    height: 24px;
}

p {
    margin: 5px 0 0;
    font-size: 12px;
}
</style>
