<script setup>
import { inject, computed } from "vue";

const rankInfos = inject("rankInfos", null);

const props = defineProps({
    isGlobal: {
        type: Boolean,
        default: false
    },
    rankColor: {
        type: String,
        default: "#6b7280",
    },
    customTitle: {
        type: String,
        default: null
    },
    title: {
        type: String,
        default: "Ranking"
    }
});

// Titre à afficher
const displayTitle = computed(() => {
    if (props.customTitle) {
        return props.customTitle;
    }
    
    if (props.isGlobal) {
        return "Global";
    }
    
    return props.title;
});

// Couleur du rang à utiliser - correction ici
const rankColorToUse = computed(() => {
    if (rankInfos?.value?.rankColor) {
        return rankInfos.value.rankColor;
    }
    
    // Calculer la couleur basée sur le nom du rang
    const rankName = rankInfos?.value?.rankName || props.title;
    
    switch (rankName.toLowerCase()) {
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
            return props.rankColor;
    }
});

// Nom du rang si disponible
const rankName = computed(() => {
    if (rankInfos?.value?.rankName) {
        return rankInfos.value.rankName;
    }
    return props.title;
});

// Afficher l'icône de rang (seulement si on a rankInfos et que ce n'est pas global)
const showRankIcon = computed(() => {
    return !props.isGlobal && !props.customTitle && rankInfos?.value;
});
</script>

<template>
    <div class="rank-title-container">
        <!-- Affichage avec icône de rang (mode League) -->
        <div v-if="showRankIcon" class="rank-title-with-icon">
            <div class="rank-title">
                <svg
                    width="35"
                    height="35"
                    viewBox="0 0 72 81"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M31.9863 1.07227C34.4615 -0.356808 37.5111 -0.356808 39.9863 1.07227L67.9727 17.2295C70.4477 18.6586 71.9727 21.3002 71.9727 24.1582V56.4736C71.9726 59.3315 70.4475 61.9723 67.9727 63.4014L39.9863 79.5596C37.5111 80.9886 34.4615 80.9886 31.9863 79.5596L4 63.4014C1.52505 61.9723 2.70523e-05 59.3316 0 56.4736V24.1582C0 21.3001 1.52487 18.6586 4 17.2295L31.9863 1.07227ZM34.9658 19.7959C34.9658 19.7959 35.4766 22.5137 35.2217 26.7109C25.1356 32.5437 18.3387 42.3005 16.4668 48.8672C14.4272 56.0121 20.1226 58.4434 24.917 54.9238C36.7506 46.2367 39.1572 26.4746 39.1572 26.4746C42.7265 25.3864 45.5626 25.9708 47.2354 27.4072C51.4189 31.0136 46.005 36.5473 45.9854 36.5674C45.9854 36.5674 44.5859 34.9261 41.9307 34.6836C37.6898 34.2982 35.5385 39.3903 41.166 39.9375C42.105 40.0308 44.5985 39.6701 45.5312 39.21C46.4702 40.9511 46.1842 49.0164 40.7432 51.4043C35.8493 53.5497 34.0332 50.54 34.0332 50.54C33.8749 50.5442 31.3974 53.8117 31.5527 54.1162C31.5845 54.1632 34.1805 57.9733 39.8291 56.3232C44.3124 55.0174 46.4638 51.1062 47.6143 48.3018C49.5295 43.6317 48.1492 39.5146 47.4092 38.4326C54.8587 33.2278 53.7644 26.158 49.1006 24.1494H49.0947C46.4582 22.8995 42.727 23.5272 39.3193 24.7646V24.752C39.568 20.0698 38.8467 18.708 38.8467 18.708L34.9658 19.7959ZM35.0596 28.6514C34.1517 39.4587 27.6973 52.3364 23.2822 53.5186V53.5127C19.1408 54.6196 20.2415 45.5284 25.4961 38.2715C30.8563 30.8716 35.0596 28.6514 35.0596 28.6514ZM41.0234 36.0947C42.8085 36.095 44.4331 37.6454 44.4434 37.6553C44.4434 37.6553 41.3465 38.812 39.9287 37.9414V37.9355C38.7286 37.1956 39.9103 36.0947 41.0234 36.0947Z"
                        :fill="rankColorToUse"
                    />
                </svg>
                <h2>{{ rankName }}</h2>
            </div>

            <div >
                <router-link to="/ranking"><p>see all</p></router-link>
            </div>
        </div>

        <!-- Affichage simple (mode Global ou Custom) -->
        <div v-else class="simple-title">
            <h2>{{ displayTitle }}</h2>
            <router-link to="/ranking"><p>see all</p></router-link>
        </div>
    </div>
</template>

<style scoped>
.rank-title-container {
    padding-bottom: 25px;
}

.rank-title-with-icon,
.simple-title {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 10px;
    justify-content: space-between;
}

.rank-title {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 10px;
}

h2 {
    color: var(--text-default, #f5f5f5);
    font-family: "Italian Plate No2";
    font-size: 32px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    letter-spacing: 0.64px;
    margin: 0;
}

p {
    color: var(--sub-text-lighter, rgba(255, 255, 255, 0.5));
    font-family: "Inter", sans-serif;
    font-size: 16px;
    font-style: normal;
    font-weight: 300;
    margin: 0;
    text-decoration: underline;
    text-decoration-thickness: 0.5px;
    text-underline-offset: 3px;
}
</style>