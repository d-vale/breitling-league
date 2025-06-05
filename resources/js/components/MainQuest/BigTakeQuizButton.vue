<script setup></script>

<template>
    <router-link to="/quiz">
        <div class="container">
            <p>Take Quiz</p>
        </div>
    </router-link>
</template>

<style scoped>
.container {
    display: flex;
    justify-content: center;
    font-family: "Italian Plate No2";
    font-size: 18px;
    font-weight: 500;
    padding: 16px;
    background-color: var(--breitling-yellow);
    border-radius: 8px;
    cursor: pointer;
}
</style>
