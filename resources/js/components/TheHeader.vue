<script setup>
import BadgePoints from "@/components/Header/BadgePoints.vue";
import InboxButton from "@/components/Header/InboxButton.vue";
import WelcomeTitle from "@/components/Header/WelcomeTitle.vue";

defineProps({
    userData: {
        type: Object,
        default: () => ({
            name: "",
            firstname: "",
            points: 0,
            rank: {
                name: ""
            }
        })
    },
    rankingData: {
        type: Object,
        default: () => ({
            position: 0,
            totalUsers: 0
        })
    },
    isLoading: {
        type: Boolean,
        default: true
    }
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