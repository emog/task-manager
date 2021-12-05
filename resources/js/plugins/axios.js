import axios from 'axios';
import NProgress from 'vue-nprogress'
import store from '../store'
import router from '../router'

axios.defaults.withCredentials = true;

// Use interceptor to inject the token to requests
axios.interceptors.request.use(request => {
    const token = store.getters['auth/token']
    if (token) {
        request.headers.common['Authorization'] = `Bearer ${token}`
    }
    return request
})


axios.interceptors.response.use(response => response, error => {
    const { status } = error.response
    const { method } = error.config



    if (status === 401 || !store.getters['auth/check']) {
        store.commit('auth/LOGOUT')
        router.push({ name: 'login' })
    }

    return Promise.reject(error)
})

