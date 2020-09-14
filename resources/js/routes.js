export default [
    { path: '/', redirect: '/logs/http' },

    {
        path: '/logs/:group',
        name: 'logs-index',
        component: require('./screens/logs/index').default,
        meta: {
            resource: 'logs',
            createTitle: ({ group }) => group.toLowerCase() + ' Logs',
        },
    },

    {
        path: '/logs/:group/:id',
        name: 'logs-show',
        component: require('./screens/logs/show').default,
        meta: {
            resource: 'logs',
            createTitle: ({ group }) => group.toLowerCase() + ' Logs - Details',
        },
    },

    {
        path: '/jobs/metrics',
        name: 'jobs-metrics',
        component: require('./screens/jobs/metrics').default,
        meta: {
            resource: 'jobs',
            createTitle: () => 'Jobs Metrics',
        },
    },

    {
        path: '/jobs/:group',
        name: 'jobs-index',
        component: require('./screens/jobs/index').default,
        meta: {
            resource: 'jobs',
            createTitle: ({ group }) => group.toLowerCase() + ' Jobs',
        },
    },

    {
        path: '/jobs/:group/:id',
        name: 'jobs-show',
        component: require('./screens/jobs/show').default,
        meta: {
            resource: 'jobs',
            createTitle: ({ group }) => group.toLowerCase() + ' Jobs - Details',
        },
    },
];
