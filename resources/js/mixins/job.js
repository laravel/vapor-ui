export default {
    methods: {
        /**
         * Returns the log color by the given display name.
         */
        jobColor(displayName) {
            return 'red';
        },

        /**
         * Returns the queue names.
         */
        queues() {
            let queues = {};

            VaporUi.queues.forEach(
                (queue) => queues[queue] = queue,
            );

            return queues;
        },
    },
};
