<script setup>
import { computed } from "vue";
import BreitlingBadge from "@/assets/BreitlingSvg.vue";

// Props reçues du parent
const props = defineProps({
    userPoints: {
        type: Number,
        default: 0
    },
    isLoading: {
        type: Boolean,
        default: false
    }
});

// Computed pour formater les points avec des apostrophes
const formattedPoints = computed(() => {
    if (props.isLoading) return "...";
    return props.userPoints.toLocaleString('fr-CH').replace(/\s/g, "'");
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