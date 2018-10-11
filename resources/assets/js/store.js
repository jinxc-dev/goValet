import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        auth: {                 // to store auth user data
            id: '',
            first_name: '',
            last_name: '',
            email: '',
            avatar: '',
            phone: '',
            type: 0,
        },
        is_auth: false,         // to store auth status
        default_role: {
            host: '',
            guest: ''
        }
    },
    mutations: {
        setAuthStatus (state) {
            state.is_auth = true;
        },
        setAuthUserDetail (state, auth) {
            for (let key of Object.keys(auth)) {
                state.auth[key] = auth[key] !== null ? auth[key] : '';
            }
            // if ('avatar' in auth)
            //     state.auth.avatar = auth.avatar !== null ? auth.avatar : '';
            state.is_auth = true;
        },
        resetAuthUserDetail (state) {
            for (let key of Object.keys(state.auth)) {
                state.auth[key] = '';
            }
            state.is_auth = false;
        },
    },
    actions: {
        setAuthStatus ({ commit }) {
            commit('setAuthStatus');
        },
        setAuthUserDetail ({ commit }, auth) {
            commit('setAuthUserDetail',auth);
        },
        resetAuthUserDetail ({commit}){
            commit('resetAuthUserDetail');
        },
    },
    getters: {
        getAuthUser: (state) => (name) => {
            return state.auth[name];
        },
        getAuthUserFullName: (state) => {
            return state.auth['first_name'] + ' '+state.auth['last_name'];
        },
        getAuthStatus: (state) => {
             return state.is_auth;
        },
        getAuthType: (state) => {
            return state.auth['type'];
        }
    },
});

export default store;
