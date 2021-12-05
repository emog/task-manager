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
    check: state => state.token !== null,
}

// mutations
export const mutations = {
    [types.SAVE_TOKEN] (state, { token, remember }) {
        state.token = token
    },

    [types.LOGOUT] (state) {
        state.user = null
        state.token = null
    },
}

// actions
export const actions = {
    saveToken ({ commit, dispatch }, payload) {
        commit(types.SAVE_TOKEN, payload)
    },
    async logout ({ commit }) {
        try {
            await axios.post('/api/v1/logout')
        } catch (e) {
        }

        commit(types.LOGOUT)
    }

}
