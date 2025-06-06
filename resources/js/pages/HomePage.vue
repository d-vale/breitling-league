<script setup>
import WidgetQuest from "../components/MainQuest/WidgetQuest.vue";
import BigTakeQuizButton from "../components/MainQuest/BigTakeQuizButton.vue";
import Table from "../components/Table/Table.vue";
import { ref, onMounted, computed, provide } from "vue";

const rankingLeague = ref({});
const rankingGlobal = ref({});
const userData = ref({
    rank: {
        name: "Bronze",
        min_points: 0,
    },
    points: 0,
});
const isLoadingUser = ref(true);

// Fonction pour calculer le rang suivant
const calculateNextRank = () => {
    const ranks = [
        { name: "Bronze", min_points: 0 },
        { name: "Silver", min_points: 25001 },
        { name: "Gold", min_points: 75001 },
        { name: "Platinum", min_points: 150001 },
        { name: "Diamond", min_points: 300001 },
        { name: "Master", min_points: 600001 },
        { name: "Timekeeper", min_points: 1200001 },
    ];

    const currentRankIndex = ranks.findIndex(
        (rank) =>
            rank.name.toLowerCase() === userData.value.rank.name.toLowerCase()
    );

    if (currentRankIndex !== -1 && currentRankIndex < ranks.length - 1) {
        return ranks[currentRankIndex + 1];
    } else {
        // Rang maximum atteint
        return { name: "Max", min_points: null };
    }
};

// Computed pour obtenir le rang suivant
const nextRank = computed(() => {
    return calculateNextRank();
});

// Computed pour obtenir la couleur du rang
const rankColor = computed(() => {
    switch (userData.value.rank.name.toLowerCase()) {
        case "bronze":
            return "#cd7f32";
        case "silver":
            return "#949494";
        case "gold":
            return "#ffc629";
        case "platinum":
            return "#42b3a7";
        case "diamond":
            return "#b9f2ff";
        case "master":
            return "#D877FF";
        case "timekeeper":
            return "#DC2543";
        default:
            return "#6b7280";
    }
});

// Computed pour calculer le pourcentage de progression vers le rang suivant
const progressPercentage = computed(() => {
    if (!nextRank.value.min_points) return 100; // Rang maximum atteint

    const currentPoints = userData.value.points;
    const currentRankMin = userData.value.rank.min_points;
    const nextRankMin = nextRank.value.min_points;

    const progressPoints = currentPoints - currentRankMin;
    const totalPointsNeeded = nextRankMin - currentRankMin;

    return Math.min(
        100,
        Math.max(0, Math.round((progressPoints / totalPointsNeeded) * 100))
    );
});

// Computed pour la largeur de la barre de progression
const progressWidth = computed(() => {
    return `${progressPercentage.value}%`;
});

// Computed pour l'icône SVG avec la couleur dynamique
const rankIcon = computed(() => {
    return `
        <svg class="rankIcon" width="72" height="81" viewBox="0 0 72 81" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M31.9863 1.07227C34.4615 -0.356808 37.5111 -0.356808 39.9863 1.07227L67.9727 17.2295C70.4477 18.6586 71.9727 21.3002 71.9727 24.1582V56.4736C71.9726 59.3315 70.4475 61.9723 67.9727 63.4014L39.9863 79.5596C37.5111 80.9886 34.4615 80.9886 31.9863 79.5596L4 63.4014C1.52505 61.9723 2.70523e-05 59.3316 0 56.4736V24.1582C0 21.3001 1.52487 18.6586 4 17.2295L31.9863 1.07227ZM34.9658 19.7959C34.9658 19.7959 35.4766 22.5137 35.2217 26.7109C25.1356 32.5437 18.3387 42.3005 16.4668 48.8672C14.4272 56.0121 20.1226 58.4434 24.917 54.9238C36.7506 46.2367 39.1572 26.4746 39.1572 26.4746C42.7265 25.3864 45.5626 25.9708 47.2354 27.4072C51.4189 31.0136 46.005 36.5473 45.9854 36.5674C45.9854 36.5674 44.5859 34.9261 41.9307 34.6836C37.6898 34.2982 35.5385 39.3903 41.166 39.9375C42.105 40.0308 44.5985 39.6701 45.5312 39.21C46.4702 40.9511 46.1842 49.0164 40.7432 51.4043C35.8493 53.5497 34.0332 50.54 34.0332 50.54C33.8749 50.5442 31.3974 53.8117 31.5527 54.1162C31.5845 54.1632 34.1805 57.9733 39.8291 56.3232C44.3124 55.0174 46.4638 51.1062 47.6143 48.3018C49.5295 43.6317 48.1492 39.5146 47.4092 38.4326C54.8587 33.2278 53.7644 26.158 49.1006 24.1494H49.0947C46.4582 22.8995 42.727 23.5272 39.3193 24.7646V24.752C39.568 20.0698 38.8467 18.708 38.8467 18.708L34.9658 19.7959ZM35.0596 28.6514C34.1517 39.4587 27.6973 52.3364 23.2822 53.5186V53.5127C19.1408 54.6196 20.2415 45.5284 25.4961 38.2715C30.8563 30.8716 35.0596 28.6514 35.0596 28.6514ZM41.0234 36.0947C42.8085 36.095 44.4331 37.6454 44.4434 37.6553C44.4434 37.6553 41.3465 38.812 39.9287 37.9414V37.9355C38.7286 37.1956 39.9103 36.0947 41.0234 36.0947Z" fill="${rankColor.value}" />
        </svg>
    `;
});

const fetchRankingDataFromLeague = async () => {
    try {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        const response = await fetch("/api/v1/ranking/league", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
        });

        if (!response.ok) {
            throw new Error("Failed to fetch ranking data");
        }

        const data = await response.json();
        if (data.success && data.data) {
            rankingLeague.value = data.data;
        } else {
            console.error("No ranking data found");
        }
    } catch (error) {
        console.error("Error fetching ranking data:", error);
    }
};

const fetchRankingDataFromGlobal = async () => {
    try {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        const response = await fetch("/api/v1/ranking/global", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
        });

        if (!response.ok) {
            throw new Error("Failed to fetch ranking data");
        }

        const data = await response.json();
        if (data.success && data.data) {
            rankingGlobal.value = data.data;
        } else {
            console.error("No ranking data found");
        }
    } catch (error) {
        console.error("Error fetching ranking data:", error);
    }
};

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

        const response = await fetch("/api/v1/user", {
            method: "GET",
            headers: defaultHeaders,
        });

        const result = await response.json();

        if (result.success && result.data) {
            userData.value = {
                rank: {
                    name: result.data.rank?.name || "Bronze",
                    min_points: result.data.rank?.min_points || 0,
                },
                points: result.data.points || 0,
            };
        }
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
    } finally {
        isLoadingUser.value = false;
    }
};

// Computed pour filtrer les données de la ligue
const filteredLeagueData = computed(() => {
    if (!rankingLeague.value.ranking) return { ranking: [] };

    const top3 = rankingLeague.value.ranking.slice(0, 3);
    const currentUser = rankingLeague.value.ranking.find(
        (user) => user.is_current_user
    );
    const currentUserPosition = rankingLeague.value.current_user_position;

    // Si l'utilisateur connecté est dans le top 3, on renvoie juste le top 3
    if (currentUser && currentUser.position <= 3) {
        return {
            ranking: top3,
            current_user: {
                position: currentUserPosition,
                nickname: currentUser.nickname,
                points: currentUser.points,
                rank_name: currentUser.rank.name,
            },
            league_name: rankingLeague.value.league_name,
            total_users_in_league: rankingLeague.value.total_users_in_league,
            isGlobal: false,
        };
    }

    // Sinon, on ajoute l'utilisateur connecté après le top 3
    const filteredRanking = currentUser ? [...top3, currentUser] : top3;

    return {
        ranking: filteredRanking,
        current_user: {
            position: currentUserPosition,
            nickname: currentUser.nickname,
            points: currentUser.points,
            rank_name: currentUser.rank.name,
        },
        league_name: rankingLeague.value.league_name,
        total_users_in_league: rankingLeague.value.total_users_in_league,
        isGlobal: false,
    };
});

// Computed pour filtrer les données globales
const filteredGlobalData = computed(() => {
    if (!rankingGlobal.value.ranking) return { ranking: [] };

    const top3 = rankingGlobal.value.ranking.slice(0, 3);
    const currentUser = rankingGlobal.value.ranking.find(
        (user) => user.is_current_user
    );
    const currentUserPosition = rankingGlobal.value.current_user_position;

    // Si l'utilisateur connecté est dans le top 3, on renvoie juste le top 3
    if (currentUser && currentUser.position <= 3) {
        return {
            ranking: top3,
            current_user: {
                position: currentUserPosition,
                nickname: currentUser.nickname,
                points: currentUser.points,
                rank_name: currentUser.rank.name,
            },
            total_users: rankingGlobal.value.total_users,
            isGlobal: true,
        };
    }

    // Sinon, on ajoute l'utilisateur connecté après le top 3
    const filteredRanking = currentUser ? [...top3, currentUser] : top3;

    return {
        ranking: filteredRanking,
        current_user: {
            position: currentUserPosition,
            nickname: currentUser.nickname,
            points: currentUser.points,
            rank_name: currentUser.rank.name,
        },
        total_users: rankingGlobal.value.total_users,
    };
});

onMounted(() => {
    fetchRankingDataFromLeague();
    fetchRankingDataFromGlobal();
    fetchUserData();
});

const rankInfos = computed(() => {
    return {
        rankColor: rankColor.value,
        rankName: userData.value.rank.name,
    };
});
provide("rankInfos", rankInfos);
</script>

<template>
    <div>
        <div class="widget-main-quest">
            <WidgetQuest
                :userData="userData"
                :isLoading="isLoadingUser"
                :rankColor="rankColor"
                :rankIcon="rankIcon"
                :progressPercentage="progressPercentage"
                :progressWidth="progressWidth"
            />
            <BigTakeQuizButton />
        </div>
        <div class="table-ranking-league">
            <Table :data="filteredLeagueData"></Table>
        </div>
        <div class="table-ranking-global">
            <Table :data="filteredGlobalData"></Table>
        </div>
    </div>
</template>

<style scoped>
.widget-main-quest {
    display: flex;
    flex-direction: column;
    width: 100%;
    gap: 16px;
    padding: 25px;
}

.table-ranking-league {
    display: flex;
    flex-direction: column;
    justify-content: center;
    width: 100%;
    padding: 25px;
}

.table-ranking-global {
    display: flex;
    flex-direction: column;
    justify-content: center;
    width: 100%;
    padding: 25px;
}

h2 {
    text-align: center;
    margin-bottom: 10px;
}

p {
    text-align: center;
    margin-bottom: 15px;
    font-weight: 500;
    color: var(--text-default);
}
</style>
