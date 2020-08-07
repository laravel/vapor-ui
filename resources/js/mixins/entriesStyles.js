export default {
    methods: {
        messageLevelColor(level) {
            if (level == '100') return 'gray';
            if (level == '200') return 'blue';
            if (level == '300') return 'yellow';
            if (level == '400') return 'red';

            return 'gray';
        },
    },
};
