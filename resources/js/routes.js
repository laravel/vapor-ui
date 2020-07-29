export default [
    { path: '/', redirect: '/logs' },

    {
        path: '/logs',
        name: 'logs',
        component: require('./screens/logs/index').default,
    },
];
