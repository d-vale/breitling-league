<script setup>
import { ref, computed, provide, onMounted, watchEffect } from "vue";
import Table from "../components/Table/Table.vue";

const rankingLeague = ref({});
const rankingGlobal = ref({});
const rankingSalesTeam = ref({}); // Ajout pour l'équipe de vente
const userData = ref({
    rank: {
        name: "Bronze",
        min_points: 0,
    },
    points: 0,
});
const isLoadingUser = ref(true);
const activeTab = ref("Global"); // Tab actif par défaut

// Computed pour obtenir les données du classement en fonction du tab actif
const currentRankingData = computed(() => {
    switch (activeTab.value) {
        case "League":
            return rankingLeague.value;
        case "Global":
            return rankingGlobal.value;
        case "Sales Team":
            return rankingSalesTeam.value;
        default:
            return rankingGlobal.value;
    }
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

// Fonction pour changer de tab
const selectTab = (tabName) => {
    activeTab.value = tabName;
    
    // Charger les données si elles ne sont pas encore chargées
    if (tabName === "League" && Object.keys(rankingLeague.value).length === 0) {
        fetchRankingDataFromLeague();
    } else if (tabName === "Global" && Object.keys(rankingGlobal.value).length === 0) {
        fetchRankingDataFromGlobal();
    } else if (tabName === "Sales Team" && Object.keys(rankingSalesTeam.value).length === 0) {
        fetchRankingDataFromSalesTeam();
    }
};

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
            console.log("League ranking data", rankingLeague.value);
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
            console.log("Global Ranking Data:", rankingGlobal.value);
        } else {
            console.error("No ranking data found");
        }
    } catch (error) {
        console.error("Error fetching ranking data:", error);
    }
};

const fetchRankingDataFromSalesTeam = async () => {
    try {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        const response = await fetch("/api/v1/ranking/pos", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
        });

        if (!response.ok) {
            throw new Error("Failed to fetch sales team ranking data");
        }

        const data = await response.json();
        if (data.success && data.data) {
            rankingSalesTeam.value = data.data;
            console.log("Sales Team Ranking Data:", rankingSalesTeam.value);
        } else {
            console.error("No sales team ranking data found");
        }
    } catch (error) {
        console.error("Error fetching sales team ranking data:", error);
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

onMounted(() => {
    // Charger seulement les données du tab actif au démarrage
    fetchRankingDataFromGlobal(); // Tab par défaut
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
    <section class="ranking-page">
        <div class="tabs">
            <button 
                class="tab" 
                :class="{ active: activeTab === 'League' }"
                @click="selectTab('League')"
            >
                League
            </button>
            <button 
                class="tab" 
                :class="{ active: activeTab === 'Global' }"
                @click="selectTab('Global')"
            >
                Global
            </button>
            <button 
                class="tab" 
                :class="{ active: activeTab === 'Sales Team' }"
                @click="selectTab('Sales Team')"
            >
                Sales Team
            </button>
        </div>
        <div class="ranking-container">
            <Table :data="currentRankingData"></Table>
        </div>
    </section>
</template>

<style scoped>
section.ranking-page {
    padding: 25px;
    gap: 25px;
}
.tabs {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    padding-bottom: 25px;
}
.tab {
    color: var(--sub-text-lighter);
    font-family: "Inter", sans-serif;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    cursor: pointer;
    border: none;
    background: none;
    transition: all 0.2s ease;
}

.tab:hover {
    color: var(--text-default, #F5F5F5);
}

.tab.active {
    color: var(--text-default, #F5F5F5);
    font-family: "Inter", sans-serif;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    text-decoration-line: underline;
    text-decoration-style: solid;
    text-decoration-skip-ink: auto;
    text-decoration-thickness: auto;
    text-underline-offset: auto;
    text-underline-position: from-font;
}

.ranking-container {
    width: 100%;
    display: flex;
    flex-direction: column;
    padding-top: 25px;
}
</style>