export default [
    { path: '/', redirect: '/requests' },

    {
        path: '/requests',
        name: 'requests',
        component: require('./screens/requests/index').default,
    },

    {
        path: '/commands',
        name: 'commands',
        component: require('./screens/commands/index').default,
    },

    {
        path: '/jobs',
        name: 'jobs',
        component: require('./screens/jobs/index').default,
    },
];
