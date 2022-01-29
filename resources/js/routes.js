export default [
    { path: '/', redirect: '/logs/http' },
    {
        path: '/logs/:group',
        name: 'logs-index',
        component: () => import(/* webpackChunkName: logs-index */ './screens/logs/index.vue'),
        meta: {
            resource: 'logs',
            createTitle: ({ group }) => group.toUpperCase() + ' Logs',
        },
    },
    {
        path: '/logs/:group/:id',
        name: 'logs-show',
        component: () => import(/* webpackChunkName: logs-show */ './screens/logs/show.vue'),
        meta: {
            resource: 'logs',
            createTitle: ({ group }) => `${group.toUpperCase()} Logs - Details`,
        },
    },
    {
        path: '/jobs/metrics',
        name: 'jobs-metrics',
        component: () => import(/* webpackChunkName: jobs-metrics */ './screens/jobs/metrics.vue'),
        meta: {
            resource: 'jobs',
            createTitle: () => 'Jobs Metrics',
        },
    },
    {
        path: '/jobs/:group',
        name: 'jobs-index',
        component: () => import(/* webpackChunkName: jobs-index */ './screens/jobs/index.vue'),
        meta: {
            resource: 'jobs',
            createTitle: ({ group }) => `${group.toUpperCase()} Jobs`,
        },
    },
    {
        path: '/jobs/:group/:id',
        name: 'jobs-show',
        component: () => import(/* webpackChunkName: jobs-show */ './screens/jobs/show.vue'),
        meta: {
            resource: 'jobs',
            createTitle: ({ group }) => `${group.toUpperCase()} Jobs - Details`,
        },
    },
];
