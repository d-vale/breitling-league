<script setup>
import { ref, computed, onMounted, watchEffect } from "vue";

const userData = ref({});
const rankName = computed(() => {
    return userData.value.rank?.name || "Unranked";
});
const isLoadingUser = ref(true);

const fetchUserData = async () => {
    try {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        const defaultHeaders = {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            Accept: "application/json",
            "X-CSRF-TOKEN": csrfToken,
        };

        const response = await fetch("/api/v1/user", {
            method: "GET",
            headers: defaultHeaders,
        });

        const result = await response.json();

        if (result.success && result.data) {
            userData.value = result.data;
        }
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
    } finally {
        isLoadingUser.value = false;
    }
};

const calculateNextRank = () => {
    const ranks = [
        { name: "Bronze", min_points: 0 },
        { name: "Silver", min_points: 25001 },
        { name: "Gold", min_points: 75001 },
        { name: "Platinum", min_points: 150001 },
        { name: "Diamond", min_points: 300001 },
        { name: "Master", min_points: 600001 },
        { name: "Timekeeper", min_points: 1200001 },
    ];

    const currentRankIndex = ranks.findIndex(
        (rank) => rank.name.toLowerCase() === rankName.value.toLowerCase()
    );

    if (currentRankIndex !== -1 && currentRankIndex < ranks.length - 1) {
        return ranks[currentRankIndex + 1];
    } else {
        // Rang maximum atteint
        return { name: "Max", min_points: null };
    }
};

// Computed pour obtenir le rang suivant
const nextRank = computed(() => {
    return calculateNextRank();
});

const nextRankColor = computed(() => {
    if (nextRank.value.min_points === null) return "#DC2543"; // Couleur pour le rang maximum
    switch (nextRank.value.name.toLowerCase()) {
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
            return "#6b7280";
    }
});

// Computed pour obtenir la couleur du rang
const rankColor = computed(() => {
    switch (rankName.value.toLowerCase()) {
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
            return "#6b7280";
    }
});

// Computed pour calculer le pourcentage de progression vers le rang suivant
const progressPercentage = computed(() => {
    if (!nextRank.value.min_points) return 100; // Rang maximum atteint

    const currentPoints = userData.value.points;
    const currentRankMin = userData.value.rank.min_points;
    const nextRankMin = nextRank.value.min_points;

    const progressPoints = currentPoints - currentRankMin;
    const totalPointsNeeded = nextRankMin - currentRankMin;

    return Math.min(
        100,
        Math.max(0, Math.round((progressPoints / totalPointsNeeded) * 100))
    );
});

// Computed pour la largeur de la barre de progression
const progressWidth = computed(() => {
    return `${progressPercentage.value}%`;
});

// Formater les nombres avec des séparateurs
const formatNumber = (num) => {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "'");
};

const userPoints = computed(() => {
    return formatNumber(userData.value.points || "no points");
});

onMounted(() => {
    fetchUserData();
});

watchEffect(() => {
    console.log("User Data:", userData.value);
    console.log("Rank Name:", rankName.value);
    console.log("Next Rank:", nextRank.value);
    console.log("Rank Color:", rankColor.value);
    console.log("Next Rank Color:", nextRankColor.value);
});
</script>

<template>
    <div class="main-quest">
        <div class="icon">
            <svg
                class="rankIcon"
                viewBox="0 0 72 81"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M31.9863 1.07227C34.4615 -0.356808 37.5111 -0.356808 39.9863 1.07227L67.9727 17.2295C70.4477 18.6586 71.9727 21.3002 71.9727 24.1582V56.4736C71.9726 59.3315 70.4475 61.9723 67.9727 63.4014L39.9863 79.5596C37.5111 80.9886 34.4615 80.9886 31.9863 79.5596L4 63.4014C1.52505 61.9723 2.70523e-05 59.3316 0 56.4736V24.1582C0 21.3001 1.52487 18.6586 4 17.2295L31.9863 1.07227ZM34.9658 19.7959C34.9658 19.7959 35.4766 22.5137 35.2217 26.7109C25.1356 32.5437 18.3387 42.3005 16.4668 48.8672C14.4272 56.0121 20.1226 58.4434 24.917 54.9238C36.7506 46.2367 39.1572 26.4746 39.1572 26.4746C42.7265 25.3864 45.5626 25.9708 47.2354 27.4072C51.4189 31.0136 46.005 36.5473 45.9854 36.5674C45.9854 36.5674 44.5859 34.9261 41.9307 34.6836C37.6898 34.2982 35.5385 39.3903 41.166 39.9375C42.105 40.0308 44.5985 39.6701 45.5312 39.21C46.4702 40.9511 46.1842 49.0164 40.7432 51.4043C35.8493 53.5497 34.0332 50.54 34.0332 50.54C33.8749 50.5442 31.3974 53.8117 31.5527 54.1162C31.5845 54.1632 34.1805 57.9733 39.8291 56.3232C44.3124 55.0174 46.4638 51.1062 47.6143 48.3018C49.5295 43.6317 48.1492 39.5146 47.4092 38.4326C54.8587 33.2278 53.7644 26.158 49.1006 24.1494H49.0947C46.4582 22.8995 42.727 23.5272 39.3193 24.7646V24.752C39.568 20.0698 38.8467 18.708 38.8467 18.708L34.9658 19.7959ZM35.0596 28.6514C34.1517 39.4587 27.6973 52.3364 23.2822 53.5186V53.5127C19.1408 54.6196 20.2415 45.5284 25.4961 38.2715C30.8563 30.8716 35.0596 28.6514 35.0596 28.6514ZM41.0234 36.0947C42.8085 36.095 44.4331 37.6454 44.4434 37.6553C44.4434 37.6553 41.3465 38.812 39.9287 37.9414V37.9355C38.7286 37.1956 39.9103 36.0947 41.0234 36.0947Z"
                    :fill="rankColor"
                />
            </svg>
        </div>

        <div class="infos">
            <div class="points">
                <p class="points">
                    {{ userPoints }}
                </p>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="25"
                    viewBox="0 0 24 25"
                    fill="none"
                >
                    <path
                        d="M13.2539 0.633545L14.4951 0.830811L15.708 1.15503L16.8809 1.60522L18 2.17554L19.0537 2.86011L20.0293 3.65015L20.918 4.53882L21.708 5.5144L22.3926 6.56812L22.9629 7.68726L23.4131 8.86011L23.7373 10.073L23.9346 11.3142L24 12.5681L23.9346 13.822L23.7373 15.0632L23.4131 16.2761L22.9629 17.449L22.3926 18.5681L21.708 19.6218L20.918 20.5974L20.0293 21.4861L19.0537 22.2761L18 22.9607L16.8809 23.531L15.708 23.9812L14.4951 24.3054L13.2539 24.5027L12 24.5681L10.7461 24.5027L9.50488 24.3054L8.29199 23.9812L7.11914 23.531L6 22.9607L4.94629 22.2761L3.9707 21.4861L3.08203 20.5974L2.29199 19.6218L1.60742 18.5681L1.03711 17.449L0.586914 16.2761L0.261719 15.0632L0.0654297 13.822L0 12.5681L0.0654297 11.3142L0.261719 10.073L0.586914 8.86011L1.03711 7.68726L1.60742 6.56812L2.29199 5.5144L3.08203 4.53882L3.9707 3.65015L4.94629 2.86011L6 2.17554L7.11914 1.60522L8.29199 1.15503L9.50488 0.830811L10.7461 0.633545L12 0.568115L13.2539 0.633545ZM11.6172 4.8728C11.6172 4.8728 11.8085 5.89251 11.7129 7.46655C7.93068 9.6539 5.38158 13.3127 4.67969 15.7751C3.91514 18.454 6.05091 19.3659 7.84863 18.0466C12.2862 14.7889 13.1895 7.37769 13.1895 7.37769C14.5278 6.96972 15.5915 7.18866 16.2188 7.72729C17.7902 9.08214 15.75 11.1628 15.75 11.1628C15.75 11.1628 15.225 10.5469 14.2295 10.4558C12.6391 10.3112 11.832 12.2213 13.9424 12.4265C14.2945 12.4615 15.2293 12.3256 15.5791 12.1531C15.9312 12.806 15.8243 15.8307 13.7842 16.7263C11.949 17.5308 11.2676 16.4021 11.2676 16.4021C11.2084 16.4035 10.2801 17.6272 10.3369 17.7429C10.3369 17.7429 11.3101 19.1937 13.4414 18.571C15.1225 18.0812 15.929 16.6139 16.3604 15.5623C17.0784 13.8111 16.5607 12.2678 16.2832 11.8621C19.0768 9.91028 18.6668 7.25888 16.918 6.50562H16.916C15.9274 6.03694 14.5278 6.27211 13.25 6.73608V6.73218C13.3422 4.99638 13.0783 4.47725 13.0723 4.46558L11.6172 4.8728ZM11.6523 8.19409C11.3118 12.2469 8.89097 17.0762 7.23535 17.5193V17.5173C5.68296 17.9315 6.09619 14.5225 8.06641 11.8015C10.0648 9.04273 11.6342 8.20374 11.6523 8.19409ZM13.8887 10.9851C14.5502 10.9851 15.1529 11.553 15.1709 11.5701C15.1539 11.5764 14.0062 12.0015 13.4785 11.6775V11.6755C13.0285 11.3981 13.4713 10.9851 13.8887 10.9851Z"
                        fill="#FFC629"
                    />
                </svg>
            </div>

            <section class="progress">
                <svg
                    class="leftIcon"
                    viewBox="0 0 72 81"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M31.9863 1.07227C34.4615 -0.356808 37.5111 -0.356808 39.9863 1.07227L67.9727 17.2295C70.4477 18.6586 71.9727 21.3002 71.9727 24.1582V56.4736C71.9726 59.3315 70.4475 61.9723 67.9727 63.4014L39.9863 79.5596C37.5111 80.9886 34.4615 80.9886 31.9863 79.5596L4 63.4014C1.52505 61.9723 2.70523e-05 59.3316 0 56.4736V24.1582C0 21.3001 1.52487 18.6586 4 17.2295L31.9863 1.07227ZM34.9658 19.7959C34.9658 19.7959 35.4766 22.5137 35.2217 26.7109C25.1356 32.5437 18.3387 42.3005 16.4668 48.8672C14.4272 56.0121 20.1226 58.4434 24.917 54.9238C36.7506 46.2367 39.1572 26.4746 39.1572 26.4746C42.7265 25.3864 45.5626 25.9708 47.2354 27.4072C51.4189 31.0136 46.005 36.5473 45.9854 36.5674C45.9854 36.5674 44.5859 34.9261 41.9307 34.6836C37.6898 34.2982 35.5385 39.3903 41.166 39.9375C42.105 40.0308 44.5985 39.6701 45.5312 39.21C46.4702 40.9511 46.1842 49.0164 40.7432 51.4043C35.8493 53.5497 34.0332 50.54 34.0332 50.54C33.8749 50.5442 31.3974 53.8117 31.5527 54.1162C31.5845 54.1632 34.1805 57.9733 39.8291 56.3232C44.3124 55.0174 46.4638 51.1062 47.6143 48.3018C49.5295 43.6317 48.1492 39.5146 47.4092 38.4326C54.8587 33.2278 53.7644 26.158 49.1006 24.1494H49.0947C46.4582 22.8995 42.727 23.5272 39.3193 24.7646V24.752C39.568 20.0698 38.8467 18.708 38.8467 18.708L34.9658 19.7959ZM35.0596 28.6514C34.1517 39.4587 27.6973 52.3364 23.2822 53.5186V53.5127C19.1408 54.6196 20.2415 45.5284 25.4961 38.2715C30.8563 30.8716 35.0596 28.6514 35.0596 28.6514ZM41.0234 36.0947C42.8085 36.095 44.4331 37.6454 44.4434 37.6553C44.4434 37.6553 41.3465 38.812 39.9287 37.9414V37.9355C38.7286 37.1956 39.9103 36.0947 41.0234 36.0947Z"
                        :fill="rankColor"
                    />
                </svg>
                <div class="progress-bar-container">
                    <div
                        class="progress-bar"
                        :style="{
                            width: progressWidth,
                            background: `linear-gradient(90deg, ${rankColor} 0%, ${nextRankColor} 100%)`,
                        }"
                    ></div>
                </div>
                <svg
                    class="rightIcon"
                    viewBox="0 0 72 81"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M31.9863 1.07227C34.4615 -0.356808 37.5111 -0.356808 39.9863 1.07227L67.9727 17.2295C70.4477 18.6586 71.9727 21.3002 71.9727 24.1582V56.4736C71.9726 59.3315 70.4475 61.9723 67.9727 63.4014L39.9863 79.5596C37.5111 80.9886 34.4615 80.9886 31.9863 79.5596L4 63.4014C1.52505 61.9723 2.70523e-05 59.3316 0 56.4736V24.1582C0 21.3001 1.52487 18.6586 4 17.2295L31.9863 1.07227ZM34.9658 19.7959C34.9658 19.7959 35.4766 22.5137 35.2217 26.7109C25.1356 32.5437 18.3387 42.3005 16.4668 48.8672C14.4272 56.0121 20.1226 58.4434 24.917 54.9238C36.7506 46.2367 39.1572 26.4746 39.1572 26.4746C42.7265 25.3864 45.5626 25.9708 47.2354 27.4072C51.4189 31.0136 46.005 36.5473 45.9854 36.5674C45.9854 36.5674 44.5859 34.9261 41.9307 34.6836C37.6898 34.2982 35.5385 39.3903 41.166 39.9375C42.105 40.0308 44.5985 39.6701 45.5312 39.21C46.4702 40.9511 46.1842 49.0164 40.7432 51.4043C35.8493 53.5497 34.0332 50.54 34.0332 50.54C33.8749 50.5442 31.3974 53.8117 31.5527 54.1162C31.5845 54.1632 34.1805 57.9733 39.8291 56.3232C44.3124 55.0174 46.4638 51.1062 47.6143 48.3018C49.5295 43.6317 48.1492 39.5146 47.4092 38.4326C54.8587 33.2278 53.7644 26.158 49.1006 24.1494H49.0947C46.4582 22.8995 42.727 23.5272 39.3193 24.7646V24.752C39.568 20.0698 38.8467 18.708 38.8467 18.708L34.9658 19.7959ZM35.0596 28.6514C34.1517 39.4587 27.6973 52.3364 23.2822 53.5186V53.5127C19.1408 54.6196 20.2415 45.5284 25.4961 38.2715C30.8563 30.8716 35.0596 28.6514 35.0596 28.6514ZM41.0234 36.0947C42.8085 36.095 44.4331 37.6454 44.4434 37.6553C44.4434 37.6553 41.3465 38.812 39.9287 37.9414V37.9355C38.7286 37.1956 39.9103 36.0947 41.0234 36.0947Z"
                        :fill="nextRankColor"
                    />
                </svg>
            </section>
        </div>

        <router-link
            to="/quiz"
            :style="{
                background: `${rankColor}`,
            }"
            class="take-quiz"
        >
            <p>Take Quiz</p>
        </router-link>
    </div>
</template>

<style scoped>
.main-quest {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 25px;
    width: 100%;
    padding: 25px;
    height: 100%;
}

.rankIcon {
    width: 100%;
    height: 100%;
    max-width: 250px;
    max-height: 250px;
}

p.points {
    color: var(--text-default, #f5f5f5);
    font-family: "Italian Plate No2";
    font-size: 24px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    margin-bottom: -4px;
}

div.points {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 10px;
}

div.infos {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 25px;
}

.progress-bar-container {
    width: 100%;
    height: 20px;
    background-color: #2c2c2c;
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    transition: width 0.3s ease;
    z-index: 100;
}

section.progress {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 15px;
    width: 100%;
}

svg.leftIcon,
svg.rightIcon {
    width: 30px;
    height: 30px;
}

.take-quiz {
    display: flex;
    width: 100%;
    height: 100%;
    padding: 16px;
    justify-content: center;
    align-items: center;
    gap: 10px;
    font-family: "Italian Plate No2";
    border-radius: 12px;
    color: var(--bg-default);
    font-size: 24px;
}
</style>
