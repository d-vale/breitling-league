<!-- Table.vue -->
<script setup>
import { computed, watchEffect } from "vue";
import Row from "./TableRow.vue";
import YourRank from "./YourRank.vue";
import RankTitle from "./RankTitle.vue";

// Props pour recevoir les données
const props = defineProps({
    data: {
        type: Object,
        default: () => ({})
    },
    // Props pour contrôler l'affichage des sections
    showTitle: {
        type: Boolean,
        default: true
    },
    showYourRank: {
        type: Boolean,
        default: true
    },
    // Titre personnalisé si pas de données de rang
    customTitle: {
        type: String,
        default: null
    }
});

// Computed properties sécurisées avec des valeurs par défaut
const ranking = computed(() => {
    return props.data?.ranking || [];
});

const currentUser = computed(() => {
    return props.data?.current_user || null;
});

const isGlobal = computed(() => {
    return props.data?.isGlobal || false;
});

// Titre à afficher
const displayTitle = computed(() => {
    if (props.customTitle) {
        return props.customTitle;
    }
    
    if (isGlobal.value) {
        return "Global";
    }
    
    // Pour les ligues, on utilise soit league_name soit le nom du rang
    return props.data?.league_name || props.data?.rank?.name || "Ranking";
});

// Props pour RankTitle
const rankTitleProps = computed(() => {
    return {
        isGlobal: isGlobal.value,
        customTitle: props.customTitle,
        title: displayTitle.value
    };
});

// Props pour YourRank
const yourRankProps = computed(() => {
    if (!currentUser.value) return null;
    
    return {
        position: currentUser.value.position || 0,
        name: currentUser.value.nickname || currentUser.value.name || "Unknown",
        points: currentUser.value.points || 0,
        isGlobal: isGlobal.value,
        rankName: currentUser.value.rank_name || currentUser.value.rank?.name || "Unranked"
    };
});

watchEffect(() => {
    if (props.data && Object.keys(props.data).length > 0) {
        console.log("TABLE DATA RECEIVED:", props.data);
        console.log("Ranking:", ranking.value);
        console.log("Current User:", currentUser.value);
        console.log("Is Global:", isGlobal.value);
    }
});
</script>

<template>
    <div>
        <!-- Titre de la section (conditionnel) -->
        <div v-if="showTitle">
            <RankTitle v-bind="rankTitleProps"></RankTitle>
        </div>
        
        <!-- Votre position (conditionnel) -->
        <div v-if="showYourRank && yourRankProps">
            <YourRank v-bind="yourRankProps"></YourRank>
        </div>
        
        <!-- Tableau principal -->
        <table class="ranking-table" v-if="ranking.length > 0">
            <thead>
                <tr>
                    <th scope="col">Rank</th>
                    <th scope="col">Name</th>
                    <th scope="col">Points</th>
                </tr>
            </thead>
            <tbody>
                <Row
                    v-for="player in ranking"
                    :key="player.user_id || player.id || player.position"
                    :position="player.position"
                    :name="player.nickname || player.name"
                    :points="player.points"
                    :rankName="player.rank?.name || player.rank_name || 'Unranked'"
                    :isGlobal="isGlobal"
                />
            </tbody>
        </table>
        
        <!-- Message si aucune donnée -->
        <div v-else class="no-data-message">
            <p>No ranking data available</p>
        </div>
    </div>
</template>

<style scoped>
.ranking-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

thead tr {
    display: flex;
    width: 100%;
    align-items: bottom;
    padding: 5px 0;
    margin-bottom: 0.5rem;
    border-bottom: 1px solid var(--card-bg);
}

th {
    color: var(--sub-text-lighter);
    font-family: "Inter", sans-serif;
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
}

th:nth-child(1) {
    flex: 0 0 auto;
    min-width: 3rem;
    text-align: left;
}

th:nth-child(2) {
    flex: 1;
    max-width: calc(50% - 3rem);
    text-align: left;
    padding: 0 1rem;
}

th:nth-child(3) {
    flex: 1;
    min-width: 50%;
    text-align: right;
}

tbody {
    display: flex;
    flex-direction: column;
}

.no-data-message {
    text-align: center;
    padding: 2rem;
    color: var(--sub-text-lighter);
    font-family: "Inter", sans-serif;
}
</style>