<script setup>
// Props reçues du composant parent
const props = defineProps({
    userData: {
        type: Object,
        required: true,
        default: () => ({
            rank: {
                name: "Bronze",
                min_points: 0,
            },
            points: 0,
        })
    },
    isLoading: {
        type: Boolean,
        default: true
    },
    rankColor: {
        type: String,
        required: true
    },
    rankIcon: {
        type: String,
        required: true
    },
    progressPercentage: {
        type: Number,
        required: true
    },
    progressWidth: {
        type: String,
        required: true
    }
});


</script>

<template>
    <div class="widget-quest">
        <!-- Icône avec couleur dynamique -->
        <div
            v-html="rankIcon"
            v-if="!isLoading"
            class="widget-quest__icon"
        ></div>

        <!-- Skeleton loader pour l'icône -->
        <div v-if="isLoading" class="widget-quest__icon-skeleton"></div>

        <div class="left-container">
            <!-- Informations du rang -->
            <div class="widget-quest__rank-info">
                <div class="widget-quest__rank-label">Your rank :</div>
                <div v-if="!isLoading" class="widget-quest__rank-name">
                    {{ userData.rank.name }}
                </div>
                <!-- Skeleton loader pour le texte -->
                <div v-if="isLoading" class="widget-quest__rank-skeleton"></div>
            </div>

            <!-- Barre de progression -->
            <div v-if="!isLoading" class="widget-quest__progress">
                <div class="widget-quest__progress-bar">
                    <div
                        class="widget-quest__progress-fill"
                        :style="{
                            width: progressWidth,
                            backgroundColor: rankColor,
                        }"
                    ></div>
                </div>
                <div class="widget-quest__progress-percentage">
                    {{ progressPercentage }}%
                </div>
            </div>

            <!-- Skeleton loader pour la barre de progression -->
            <div v-if="isLoading" class="widget-quest__progress-skeleton">
                <div class="widget-quest__progress-bar-skeleton"></div>
                <div class="widget-quest__progress-percentage-skeleton"></div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.widget-quest {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    background-color: var(--card-bg);
    border-radius: 20px;
    width: 100%;
    box-sizing: border-box;
}

.widget-quest__icon {
    flex-shrink: 0;
}

.left-container {
    display: flex;
    flex-direction: column;
    gap: 16px;
    flex: 1;
}

.widget-quest__icon-skeleton {
    width: 72px;
    height: 81px;
    background-color: #404040;
    border-radius: 8px;
    animation: pulse 1.5s ease-in-out infinite;
}

.widget-quest__rank-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex: 1;
}

.widget-quest__rank-label {
    color: #c5c5c5;
    font-family: "Open Sans Condensed", sans-serif;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    margin: 0;
}

.widget-quest__rank-name {
    color: #fff;
    font-family: "Open Sans", sans-serif;
    font-size: 24px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
    margin: 0;
}

.widget-quest__rank-skeleton {
    width: 120px;
    height: 28px;
    background-color: #404040;
    border-radius: 4px;
    animation: pulse 1.5s ease-in-out infinite;
}

.widget-quest__progress {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 8px;
    min-width: 200px;
}

.widget-quest__progress-bar {
    width: 100%;
    height: 12px;
    background-color: #999999;
    border-radius: 100px;
    overflow: hidden;
    position: relative;
}

.widget-quest__progress-fill {
    height: 100%;
    border-radius: 100px;
    transition: width 0.5s ease-out;
}

.widget-quest__progress-percentage {
    color: #c5c5c5;
    font-family: "Open Sans", sans-serif;
    font-size: 12px;
    font-weight: 400;
    line-height: normal;
    align-self: flex-end;
}

.widget-quest__progress-skeleton {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    min-width: 200px;
}

.widget-quest__progress-bar-skeleton {
    width: 100%;
    height: 12px;
    background-color: #404040;
    border-radius: 100px;
    animation: pulse 1.5s ease-in-out infinite;
}

.widget-quest__progress-percentage-skeleton {
    width: 40px;
    height: 14px;
    background-color: #404040;
    border-radius: 4px;
    align-self: flex-end;
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
    0%,
    100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}
</style>