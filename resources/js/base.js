import _ from 'lodash';
import moment from 'moment-timezone';

export default {
    methods: {
        /**
         * Returns an moment instance.
         */
        moment() {
            return moment;
        },

        /**
         * Creates a debounced function that delays invoking a callback.
         */
        debouncer: _.debounce((callback) => callback(), 500),
    },
};
