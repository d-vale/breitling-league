<script setup>
import { computed } from "vue";

// Props reçues du parent
const props = defineProps({
    userName: {
        type: String,
        default: "User"
    },
    userRank: {
        type: String,
        default: "Unranked"
    },
    userPosition: {
        type: Number,
        default: 0
    },
    totalUsers: {
        type: Number,
        default: 0
    },
    isLoading: {
        type: Boolean,
        default: false
    }
});

// Computed pour obtenir la couleur du rang
const rankColor = computed(() => {
    switch (props.userRank.toLowerCase()) {
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
            return "#D877FF";
        case "timekeeper":
            return "#DC2543";
        default:
            return "#6b7280";
    }
});

// Computed pour afficher le rang et la position
const displayRankPosition = computed(() => {
    if (props.isLoading) return "Loading...";
    return `${props.userRank} #${props.userPosition}`;
});
</script>

<template>
    <div class="welcome-container">
        <h1 class="welcome-text">Welcome {{ userName }}</h1>
        <p class="ranking-text">
            <span :style="{ color: rankColor }">
                {{ displayRankPosition }}
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