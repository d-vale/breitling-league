<!-- Row.vue -->
<script setup>
defineProps({
    position: {
        type: Number,
        required: true,
        default: 0,
    },
    name: {
        type: String,
        required: true,
        default: "No Data",
    },
    points: {
        type: Number,
        required: true,
        default: 0,
    },
});
</script>

<template>
    <tr class="ranking-row">
        <td class="rank-cell">
            <span class="rank-number">{{ position }}</span>
        </td>
        <td class="name-cell">
            <span class="player-name">{{ name }}</span>
        </td>
        <td class="points-cell">
            <span class="points"
                >{{ points.toLocaleString() }}
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
            </span>
        </td>
    </tr>
</template>

<style scoped>
.ranking-row {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    background-color: #FFC62926;
    padding: 5px;
    border-radius: 8px;
    margin-bottom: 16px;
}

.rank-cell {
    flex: 0 0 auto;
    min-width: 3rem;
}

.rank-number {
    color: var(--text-default);
    font-family: "Inter", sans-serif;
    font-size: 16px;
    font-weight: 400;
}

.name-cell {
    flex: 1;
    text-align: left;
    padding: 0 1rem;
}

.player-name {
    color: var(--text-default);
    font-family: "Inter", sans-serif;
    font-size: 16px;
    font-weight: 400;
}

.points-cell {
    flex: 0 0 auto;
    text-align: right;
}

.points {
    color: var(--text-default, #f5f5f5);
    font-family: "Inter", sans-serif;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 8px;
}
</style>
