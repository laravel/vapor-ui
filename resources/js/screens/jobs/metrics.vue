<template>
    <main class="flex-1 relative pb-8 z-0 overflow-y-auto">
        <!-- Troubleshooting -->
        <div class="m-8" v-if="troubleshooting">
            <div class="px-6 py-4 bg-white shadow-md rounded-lg">
                <!-- Create Your First Project -->
                <div class="flex items-center">
                    <icon-exclamation :size="6" />

                    <div class="ml-3 font-semibold text-sm text-gray-600 uppercase tracking-wider">Server Error</div>
                </div>

                <div class="mt-3 text-sm text-gray-700">
                    <p>It looks like there was an error. Please check your application logs.</p>
                </div>
            </div>
        </div>

        <div class="m-8" v-if="!troubleshooting">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-lg leading-6 font-medium text-cool-gray-900">Overview</h2>
                <div class="mt-5 grid grid-cols-1 rounded-lg bg-white overflow-hidden shadow md:grid-cols-3">
                    <!-- Card -->

                    <metric
                        title="Processed Jobs Past Hour"
                        :value="metrics.processed.pastHour"
                        :average="metrics.processed.averagePast24Hours"
                        :description="`Processed jobs includes successfully executed jobs, failed jobs, and retry attempts.`"
                    />

                    <metric
                        title="Failed Jobs Past Hour"
                        :value="metrics.failed.pastHour"
                        :average="metrics.failed.averagePast24Hours"
                        :increaseColor="'red'"
                        :decreaseColor="'green'"
                    />

                    <metric
                        title="Pending Jobs"
                        :value="metrics.pending"
                        :description="`Pending jobs may not be accurate, and if often subject to at least a 1-minute delay.`"
                    />
                </div>
            </div>
        </div>

        <div class="m-8" v-if="!troubleshooting">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-lg leading-6 font-medium text-cool-gray-900">Processed Jobs</h2>
                <div class="mt-5 rounded-lg bg-white overflow-hidden shadow">
                    <div class="px-6 pt-6 pb-4 bg-white shadow-md rounded-lg">
                        <div style="height: 200px" v-if="metrics.processed.timeseries === undefined">
                            <loader class="text-gray-500" />
                        </div>
                        <bar-chart
                            label="Jobs"
                            height="200px"
                            :data="
                                metrics.processed.timeseries.map(({ timestamp, value }) => ({
                                    label: formatMetricDate(timestamp),
                                    value,
                                }))
                            "
                            :format-tooltip-title="formatTooltipTitle"
                            :suggested-max="suggestedMax(metrics.processed.timeseries)"
                            v-else
                        >
                        </bar-chart>
                    </div>
                </div>
            </div>
        </div>

        <div class="m-8" v-if="!troubleshooting">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-lg leading-6 font-medium text-cool-gray-900">Failed Jobs</h2>
                <div class="mt-5 rounded-lg bg-white overflow-hidden shadow">
                    <div class="px-6 pt-6 pb-4 bg-white shadow-md rounded-lg">
                        <div style="height: 200px" v-if="metrics.failed.timeseries === undefined">
                            <loader class="text-gray-500" />
                        </div>
                        <bar-chart
                            label="Jobs"
                            height="200px"
                            :data="
                                metrics.failed.timeseries.map(({ timestamp, value }) => ({
                                    label: formatMetricDate(timestamp),
                                    value,
                                }))
                            "
                            :format-tooltip-title="formatTooltipTitle"
                            :suggested-max="suggestedMax(metrics.failed.timeseries)"
                            v-else
                        >
                        </bar-chart>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import axios from 'axios';
import InteractsWithMetrics from './../../mixins/interactsWithMetrics';

export default {
    /**
     * The component's mixins.
     */
    mixins: [InteractsWithMetrics],

    /**
     * The component's data.
     */
    data() {
        return {
            troubleshooting: false,
            metrics: {
                processed: {},
                failed: {},
            },
        };
    },

    /**
     * Prepare the component.
     */
    mounted() {
        return axios
            .get('/vapor-ui/api/jobs/metrics')
            .then(({ data }) => {
                this.metrics = data;
            })
            .catch(() => {
                this.troubleshooting = true;

                throw 'Server error.';
            });
    },
};
</script>
