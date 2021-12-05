import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
    user: null,
    token: '',
}

// getters
export const getters = {
    user: state => state.user,
    token: state => state.token,
    check: state => state.user !== null,
}

// mutations
export const mutations = {
    [types.SAVE_TOKEN] (state, { token, remember }) {
        state.token = token
    },

    [types.FETCH_USER_SUCCESS] (state, { user }) {
        state.user = user
    },


    [types.FETCH_USER_FAILURE] (state) {
        state.token = null
    },

    [types.LOGOUT] (state) {
        state.user = null
        state.token = null
    },

    [types.UPDATE_USER] (state, { user }) {
        state.user = user
    }
}

// actions
export const actions = {
    saveToken ({ commit, dispatch }, payload) {
        commit(types.SAVE_TOKEN, payload)
    },

    saveRememberMe ({ commit, dispatch }, payload) {
        commit(types.REMEMBER_ME, payload)
    },

    async fetchUser ({ commit }) {
        try {
            const { data } = await axios.get('/api/v1/user')
            commit(types.FETCH_USER_SUCCESS, { user: data.data })
        } catch (e) {
            commit(types.FETCH_USER_FAILURE)
        }
    },
    updateUser ({ commit }, payload) {
        commit(types.UPDATE_USER, payload)
    },

    async logout ({ commit }) {
        try {
            await axios.post('/api/v1/logout')
        } catch (e) {
        }

        commit(types.LOGOUT)
    }

}
