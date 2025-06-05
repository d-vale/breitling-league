<script setup>
import BadgePoints from "@/components/Header/BadgePoints.vue";
import InboxButton from "@/components/Header/InboxButton.vue";
import WelcomeTitle from "@/components/Header/WelcomeTitle.vue";
import { ref, onMounted, provide } from "vue";

// États centralisés
const userData = ref({
    name: "",
    firstname: "",
    points: 0,
    rank: {
        name: ""
    }
});

provide("userData", userData);

const rankingData = ref({
    position: 0,
    totalUsers: 0
});

const isLoading = ref(true);

// Fonction centralisée pour récupérer toutes les données utilisateur
const fetchAllUserData = async () => {
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

        // Récupération des données utilisateur et du ranking en parallèle
        const [userResponse, rankingResponse] = await Promise.all([
            fetch("/api/v1/user", {
                method: "GET",
                headers: defaultHeaders,
            }),
            fetch("/api/v1/ranking/pos", {
                method: "GET",
                headers: defaultHeaders,
            })
        ]);

        // Traitement des données utilisateur
        const userResult = await userResponse.json();
        if (userResult.success && userResult.data) {
            userData.value = {
                name: userResult.data.name || "",
                firstname: userResult.data.firstname || "",
                points: userResult.data.points || 0,
                rank: {
                    name: userResult.data.rank?.name || "Unranked"
                }
            };
        }

        // Traitement des données de ranking
        const rankingResult = await rankingResponse.json();
        if (rankingResult.success && rankingResult.data) {
            rankingData.value = {
                position: rankingResult.data.global_ranking?.position || 0,
                totalUsers: rankingResult.data.global_ranking?.total_users || 0
            };
        }

    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    fetchAllUserData();
});
</script>

<template>
    <div class="header-container">
        <div class="left-container">
            <WelcomeTitle 
                :user-name="userData.firstname || userData.name || 'User'"
                :user-rank="userData.rank.name"
                :user-position="rankingData.position"
                :total-users="rankingData.totalUsers"
                :is-loading="isLoading"
            />
        </div>

        <div class="right-container">
            <BadgePoints 
                :user-points="userData.points"
                :is-loading="isLoading"
            />
            <InboxButton />
        </div>
    </div>
</template>

<style scoped>
.header-container {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 25px;
}

.left-container {
    display: flex;
    align-items: top;
}

.right-container {
    display: flex;
    align-items: top;
    gap: 10px;
}
</style>