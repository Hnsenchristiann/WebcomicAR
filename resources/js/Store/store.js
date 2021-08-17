import axios from "axios";
import Vue from "vue";
import Vuex from 'vuex';

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        user: null,
        token: localStorage.getItem('token') || null,
        tokenExpiration: localStorage.getItem('token_expiration') || null
    },
    mutations: {
        setAxiosCurrentToken(state){
            let token = localStorage.getItem('token')
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
        },
        setToken (state, data) {
            let expire = Date.now() + (60000 * 60 * 24 * 30)
            localStorage.setItem('token', data.token)
            localStorage.setItem('token_expiration', expire)
            state.token = data.token
            state.tokenExpiration = expire
            axios.defaults.headers.common.Authorization = `Bearer ${data.token}`
        },
        clearUserData () {
            localStorage.removeItem('token')
            localStorage.removeItem('token_expiration')
        },
        retrieveToken(state, token){
            state.token = token
        },
        destroyToken(state){
            state.token = null
            state.tokenExpiration = null
        },
    },
    actions: {
        register({ commit }, credentials) {
            return axios.post(route('api.register'), credentials)
            .then(({ data }) => {
                commit('clearUserData')
                commit('setToken', data)
            })
        },
        login({ commit }, credentials) {
            return axios.post(route('api.login'), credentials)
            .then(({ data }) => {
                commit('clearUserData')
                commit('setToken', data)
            })
        },
        logout({ commit }) {
            return axios.get(route('api.logout'))
            .then((response) => {
                commit('clearUserData')
                commit('destroyToken')
            })
        }
    },
    getters : {
        loggedIn(state){
            let now = Date.now()
            return state.token !== null && now < parseInt(state.tokenExpiration)
        },
        tokenExpired(state){
            let now = Date.now()
            return now > parseInt(state.tokenExpiration)
        }
    }
})

export default store
