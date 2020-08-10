export default {
    methods: {
        /**
         * Returns the log types.
         */
        logTypes() {
            return {
                debug: 'Debug',
                info: 'Info',
                notice: 'Notice',
                warning: 'Warning',
                alert: 'Alert',
                critical: 'Critical',
                emergency: 'Emergency',
                timeout: 'Timeout',
                error: 'Error',
            };
        },

        /**
         * Returns the log color by the given type.
         */
        logColor(type) {
            const compare = (level) => level === type.toLowerCase();

            if (['info', 'notice'].some(compare)) {
                return 'blue';
            }

            if (['warning', 'alert'].some(compare)) {
                return 'yellow';
            }

            if (['critical', 'emergency', 'error', 'timeout'].some(compare)) {
                return 'red';
            }

            return 'gray';
        },
    },
};
