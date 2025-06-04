<script setup>
import { ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import profileSvg from "../assets/navbar-icons/profile-icon.svg"; // Ajustez le chemin selon votre structure

const router = useRouter();
const route = useRoute();

const isActive = ref(route.name === "profile");

const goToProfile = () => {
    router.push({ name: "profile" });
};
</script>

<template>
    <div class="nav-item" @click="goToProfile" :class="{ active: false }">
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

p {
    margin: 5px 0 0;
    font-size: 12px;
}
</style>
