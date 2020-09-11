import moment from 'moment';

import InteractsWithQuantiy from './interactsWithQuantity';

export default {
    /**
     * The mixin's mixins.
     */
    mixins: [InteractsWithQuantiy],

    /**
     * The mixin's methods.
     */
    methods: {
        /**
         * Formats the give date to a human readable format.
         */
        formatMetricDate(date) {
            return moment
                .utc(date * 1000, 'x')
                .local()
                .format('LT')
                .replace(/:[0-9]{2}/, '');
        },

        /**
         * Formats the given label to a tooltip title.
         */
        formatTooltipTitle([{ label }]) {
            return label + ' - ' + moment(label, 'LT').add(1, 'hours').format('LT');
        },

        /**
         * Gets the max value of the given timeseries.
         */
        suggestedMax(timeseries) {
            const data = timeseries.map((point) => point.value);

            return Math.max(Math.max(...data), 1);
        },
    },
};
