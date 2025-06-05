<script setup>
import BadgePoints from "@/components/Header/BadgePoints.vue";
import InboxButton from "@/components/Header/InboxButton.vue";
import WelcomeTitle from "@/components/Header/WelcomeTitle.vue";
</script>

<template>
    <div class="header-container">
        <div class="left-container">
            <WelcomeTitle />
        </div>

        <div class="right-container">
            <BadgePoints />
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
