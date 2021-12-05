import Login from './../pages/Login';
const Tasks = () => import('./../pages/Tasks');


const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/tasks',
        name: 'tasks',
        component: Tasks
    }
];

export default routes;
