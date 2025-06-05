<script setup>
import { RouterView } from "vue-router";
import { ref, onMounted } from "vue";
import TheNavBar from "./components/TheNavBar.vue";
import TheHeader from "./components/TheHeader.vue";


// États centralisés
const userData = ref({
    name: "",
    firstname: "",
    points: 0,
    rank: {
        name: ""
    }
});

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
    <header>
        <TheHeader :userData="userData" :rankingData="rankingData" :isLoading="isLoading"/>
    </header>
    <main>
        <RouterView></RouterView>
    </main>
    <footer><TheNavBar /></footer>
</template>

<style>
:root {
    background-color: #000000;
}

html,
body {
    background-color: #000000;
    overflow-x: hidden;
}

/* Hide scrollbar for Chrome, Safari and Opera */
::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
* {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}
</style>
