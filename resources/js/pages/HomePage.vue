<script setup>
import WidgetQuest from "../components/MainQuest/WidgetQuest.vue";
import BigTakeQuizButton from "../components/MainQuest/BigTakeQuizButton.vue";
</script>

<template>
    <div>
        <div class="widget-main-quest">
            <WidgetQuest />
            <BigTakeQuizButton />
        </div>

        <h1>Welcome to the Home Page</h1>
        <p>This is the main content of the home page.</p>
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
</style>
