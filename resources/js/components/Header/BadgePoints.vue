<script setup>
import { ref, onMounted, computed } from "vue";
import BreitlingBadge from "@/assets/BreitlingSvg.vue";

const userPoints = ref(0);

// Computed pour formater les points avec des apostrophes
const formattedPoints = computed(() => {
    return userPoints.value.toLocaleString('fr-CH').replace(/\s/g, "'");
});

const fetchUserPoints = async () => {
    try {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        const defaultHeaders = {
            "Content-Type": "application/json",
            "X-Requested-With": "XmlHttpRequest",
            Accept: "application/json",
            "X-CSRF-TOKEN": csrfToken,
        };
        const response = await fetch("/api/v1/user", {
            method: "GET",
            headers: defaultHeaders,
        });

        const user = await response.json();

        if (user.success && user.data) {
            userPoints.value = user.data.points || 0;
        }
    } catch (error) {
        console.error("Erreur lors de la récupération des points:", error);
    }
};

onMounted(() => {
    fetchUserPoints();
});
</script>

<template>
    <div class="badge-points-container">
        <BreitlingBadge />
        <div class="badge-points">
            <span class="points">{{ formattedPoints }}</span>
        </div>
    </div>
</template>

<style scoped>
.badge-points-container {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
}

.badge-points {
    position: relative;
    top: -10px;
    display: inline-flex;
    font-size: 14px;
    font-family: "Italian Plate No2";
    border-radius: 1000px;
    padding-bottom: 1px;
    padding-top: 3px;
    padding-left: 7px;
    padding-right: 7px;
    background-color: #ffc629;
}

span.points {
    padding: 0px;
    margin: 0px;
    line-height: 1;
    display: block;
}
</style>