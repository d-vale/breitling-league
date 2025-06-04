<script setup>
import WelcomeTitle from './Header/WelcomeTitle.vue';
import BadgePoints from './Header/BadgePoints.vue';
import InboxButton from './Header/InboxButton.vue';
</script>

<template>
  <header class="header">
    <WelcomeTitle />
    <div class="right-section">
      <BadgePoints />
      <InboxButton />
    </div>
  </header>
</template>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  background-color: #000;
}

.right-section {
  display: flex;
  align-items: center;
  gap: 15px;
}
</style>
