<!-- RankingTable.vue -->
<script setup>
import { computed, watchEffect } from "vue";
import Row from "./TableRow.vue";
import YourRank from "./YourRank.vue";
import RankTitle from "./RankTitle.vue";

// Props pour recevoir les données
const props = defineProps({
    data: {
        type: Object,
    },
});

const ranking = computed(() => {
    return props.data.ranking;
});

const currentUser = computed(() => {
    if (props.data.current_user) {
        return props.data.current_user;
    }
});

const isGlobal = computed(() => {
    return props.data.isGlobal;
});

watchEffect(() => {
    if (props.data.current_user) {
        console.log("Current User Position:", props.data.current_user);
    }
});
</script>

<template>
    <div>
        <RankTitle :isGlobal="isGlobal"></RankTitle>
    </div>
    <div>
        <YourRank
            :position="currentUser?.position"
            :name="currentUser?.nickname"
            :points="currentUser?.points"
        ></YourRank>
    </div>
    <table class="ranking-table">
        <thead>
            <tr>
                <th scope="col">Rank</th>
                <th scope="col">Name</th>
                <th scope="col">Points</th>
            </tr>
        </thead>
        <tbody>
            <Row
                v-for="player in ranking"
                :key="player.user_id"
                :rank="player.position"
                :name="player.nickname"
                :points="player.points"
                :isGlobal="isGlobal"
            />
        </tbody>
    </table>
</template>

<style scoped>
.ranking-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

thead tr {
    display: flex;
    width: 100%;
    align-items: bottom;
    padding: 5px 0;
    margin-bottom: 0.5rem;
    border-bottom: 1px solid var(--card-bg);
}

th {
    color: var(--sub-text-lighter);
    font-family: "Inter", sans-serif;
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
}

th:nth-child(1) {
    flex: 0 0 auto;
    min-width: 3rem;
    text-align: left;
}

th:nth-child(2) {
    flex: 1;
    max-width: calc(50% - 3rem);
    text-align: left;
    padding: 0 1rem;
}

th:nth-child(3) {
    flex: 1;
    min-width: 50%;
    text-align: right;
}

tbody {
    display: flex;
    flex-direction: column;
}
</style>
