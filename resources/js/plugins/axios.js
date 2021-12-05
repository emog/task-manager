import axios from 'axios';
import NProgress from 'vue-nprogress'
import store from '../store'
import router from '..//router'

// Use interceptor to inject the token to requests
axios.interceptors.request.use(request => {
    const token = store.getters['auth/token']
    if (token) {
        request.headers.common['Authorization'] = `Bearer ${token}`
    }
    return request
})

// before a request is made start the nprogress
axios.interceptors.request.use(config => {
    NProgress.start();
    return config
});

// before a response is returned stop nprogress
axios.interceptors.response.use(response => {
    NProgress.done();
    return response
});

axios.interceptors.response.use(response => response, error => {
    const { status } = error.response
    const { method } = error.config



    if (status === 401 && store.getters['auth/check']) {
        store.commit('auth/LOGOUT')
        router.push({ name: 'login' })
    }

    if (status === 403 && store.getters['auth/check']) {

    }

    return Promise.reject(error)
})

