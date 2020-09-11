<template>
    <div class="relative" :style="{ height: height }">
        <canvas ref="canvas"></canvas>
    </div>
</template>

<script>
import Chart from 'chart.js';

export default {
    /**
     * The component's computed properties.
     */
    computed: {
        chartLabels() {
            return this.data.map((dataPoint) => dataPoint.label);
        },

        chartData() {
            return this.data.map((dataPoint) => dataPoint.value);
        },
    },

    /**
     * Prepare the component.
     */
    mounted() {
        Chart.defaults.global.defaultFontFamily = 'Nunito, sans-serif';

        new Chart(this.$refs.canvas, {
            type: 'bar',
            data: {
                labels: this.chartLabels,
                datasets: [
                    {
                        steppedLine: 'after',
                        pointBorderColor: 'rgba(0, 0, 0, 0)',
                        pointBackgroundColor: 'rgba(0, 0, 0, 0)',
                        label: this.label,
                        data: this.chartData,
                        backgroundColor: 'hsla(265, 86%, 86%, 0.4)',
                        borderColor: 'hsla(260, 73%, 70%, 0.4)',
                        borderWidth: 1,
                        lineTension: 0.2,
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false,
                },
                tooltips: {
                    displayColors: false,
                    callbacks: {
                        title: this.formatTooltipTitle,
                    },
                },
                scales: {
                    yAxes: [
                        {
                            gridLines: {
                                color: 'rgba(0, 0, 0, .05)',
                                zeroLineColor: 'rgba(0, 0, 0, 0)',
                                drawBorder: false,
                                drawTicks: false,
                                display: true,
                            },
                            ticks: {
                                beginAtZero: true,
                                display: true,
                                suggestedMax: this.suggestedMax,
                                padding: 15,
                            },
                        },
                    ],
                    xAxes: [
                        {
                            barThickness: 'flex',
                            barPercentage: 1,
                            categoryPercentage: 0.9,
                            gridLines: {
                                drawBorder: false,
                                display: false,
                                drawTicks: false,
                                offsetGridLines: true,
                            },
                            ticks: {
                                display: true,
                                maxTicksLimit: 10,
                                maxRotation: 0,
                                padding: 10,
                            },
                        },
                    ],
                },
            },
        });
    },

    /**
     * The component's props.
     */
    props: ['label', 'data', 'height', 'formatTooltipTitle', 'suggestedMax'],
};
</script>
