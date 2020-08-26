export default [
    { path: '/', redirect: '/logs/http' },

    {
        path: '/logs/:group',
        name: 'logs-index',
        component: require('./screens/logs/index').default,
        meta: {
            resource: 'logs',
            createTitle: ({ group }) => group.toUpperCase() + ' Logs',
        },
    },

    {
        path: '/logs/:group/:id',
        name: 'logs-show',
        component: require('./screens/logs/show').default,
        meta: {
            resource: 'logs',
            createTitle: ({ group }) => group.toUpperCase() + ' Logs - Details',
        },
    },

    {
        path: '/jobs/:group',
        name: 'jobs-index',
        component: require('./screens/jobs/index').default,
        meta: {
            resource: 'jobs',
            createTitle: ({ group }) => group.toUpperCase() + ' Jobs',
        },
    },

    {
        path: '/jobs/:group/:id',
        name: 'jobs-show',
        component: require('./screens/jobs/show').default,
        meta: {
            resource: 'jobs',
            createTitle: ({ group }) => group.toUpperCase() + ' Jobs - Details',
        },
    },
];
