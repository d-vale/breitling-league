<script setup>
import { ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import homeSvg from "../assets/navbar-icons/home-icon.svg"; // Ajustez le chemin selon votre structure

const router = useRouter();
const route = useRoute();

const isActive = ref(route.name === "home");

const goToHome = () => {
    router.push({ name: "home" });
};
</script>

<template>
    <div class="nav-item" @click="goToHome" :class="{ active: false }">
        <svg
            width="20"
            height="21"
            viewBox="0 0 20 21"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M13.2 20V12C13.2 11.7348 13.0947 11.4804 12.9071 11.2929C12.7196 11.1053 12.4652 11 12.2 11H8.20009C7.93487 11 7.68052 11.1053 7.49299 11.2929C7.30546 11.4804 7.2001 11.7348 7.2001 12V20M1.2002 9C1.20013 8.70907 1.26353 8.42162 1.38598 8.15772C1.50843 7.89381 1.68699 7.6598 1.90918 7.47201L8.90908 1.47303C9.27006 1.16794 9.72742 1.00055 10.2001 1.00055C10.6727 1.00055 11.1301 1.16794 11.491 1.47303L18.4909 7.47201C18.7131 7.6598 18.8917 7.89381 19.0141 8.15772C19.1366 8.42162 19.2 8.70907 19.1999 9V18C19.1999 18.5304 18.9892 19.0391 18.6141 19.4142C18.2391 19.7892 17.7304 20 17.1999 20H3.20016C2.66974 20 2.16104 19.7892 1.78597 19.4142C1.41091 19.0391 1.2002 18.5304 1.2002 18V9Z"
                :stroke="isActive ? '#FFC107' : '#F5F5F5'"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
        <p>Home</p>
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
