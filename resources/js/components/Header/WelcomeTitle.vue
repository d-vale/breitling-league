<script setup>
import { ref, onMounted, computed } from "vue";

const userName = ref("");
const userRank = ref("");
const userPosition = ref(0);
const totalUsers = ref(0);

// Computed pour obtenir la couleur du rang
const rankColor = computed(() => {
    switch (userRank.value.toLowerCase()) {
        case "bronze":
            return "#cd7f32";
        case "silver":
            return "#949494";
        case "gold":
            return "#ffc629";
        case "platinum":
            return "#42B3A7";
        case "diamond":
            return "#B9F2FF";
        case "master":
            return "#D877FF"; // Or pour Master
        case "timekeeper":
            return "#DC2543"; // 
        default:
            return "#6b7280"; // 
    }
});

const fetchUserData = async () => {
    try {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        const defaultHeaders = {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            Accept: "application/json",
            "X-CSRF-TOKEN": csrfToken,
        };

        // Fetch user data
        const userResponse = await fetch("/api/v1/user", {
            method: "GET",
            headers: defaultHeaders,
        });
        const userData = await userResponse.json();

        if (userData.success && userData.data) {
            userName.value =
                userData.data.firstname || userData.data.name || "User";
            userRank.value = userData.data.rank?.name || "Unranked";
        }

        // Fetch ranking position
        const rankingResponse = await fetch("/api/v1/ranking/pos", {
            method: "GET",
            headers: defaultHeaders,
        });
        const rankingData = await rankingResponse.json();

        if (rankingData.success && rankingData.data) {
            userPosition.value = rankingData.data.global_ranking?.position || 0;
            totalUsers.value =
                rankingData.data.global_ranking?.total_users || 0;
        }
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
    }
};

onMounted(() => {
    fetchUserData();
});
</script>

<template>
    <div class="welcome-container">
        <h1 class="welcome-text">Welcome {{ userName }}</h1>
        <p class="ranking-text">
            <span :style="{ color: rankColor }"
                >{{ userRank }} #{{ userPosition }}
            </span>
        </p>
    </div>
</template>

<style scoped>
.welcome-container {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.welcome-text {
    font-size: 16px;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.5);
    margin: 0;
    line-height: 1.2;
    font-family: "Open Sans Condensed", serif;
}

.ranking-text {
    font-size: 20px;
    font-weight: 400;
    margin: 0;
    line-height: 1;
    font-family: "Open Sans Condensed", serif;
}


</style>
