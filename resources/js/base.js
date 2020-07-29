import _ from 'lodash';
import moment from 'moment-timezone';

export default {
    methods: {
        /**
         * Creates a debounced function that delays invoking a callback.
         */
        debouncer: _.debounce((callback) => callback(), 500),
    },
};
