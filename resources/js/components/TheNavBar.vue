<script setup>
import HomeButton from './Nav/HomeButton.vue';
import BattleButton from './Nav/BattleButton.vue';
import QuestButton from './Nav/QuestButton.vue';
import RankingButton from './Nav/RankingButton.vue';
import ProfileButton from './Nav/ProfileButton.vue';
</script>

<template>
  <nav class="navbar">
    <HomeButton />
    <BattleButton />
    <QuestButton />
    <RankingButton />
    <ProfileButton />
  </nav>
</template>

<style scoped>
.navbar {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  display: flex;
  justify-content: space-around;
  align-items: center;
  background-color: #000;
  padding: 10px 0;
  width: 100%;
  z-index: 100;
}
</style>
