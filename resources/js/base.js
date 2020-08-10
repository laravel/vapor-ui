import _ from 'lodash';
import moment from 'moment-timezone';

export default {
    methods: {
        /**
         * Returns an moment instance.
         */
        moment() {
            // moment.updateLocale('en');

            return moment;
        },

        /**
         * Returns the list of the log types.
         */
        logTypes() {
            return App.logTypes;
        },

        /**
         * Creates a debounced function that delays invoking a callback.
         */
        debouncer: _.debounce((callback) => callback(), 500),
    },
};
