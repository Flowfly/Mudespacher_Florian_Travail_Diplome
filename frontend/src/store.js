import Vue from 'vue'
import Vuex from 'vuex'
import API from '../src/API.js'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        interfaceSettings: {},
    },
    mutations: {
        setInterface(state, params) {
            state.interfaceSettings = params;
        }
    },
    actions: {
        getActualQuestion() {
            API.getActualQuestion()
                .done((response) => {
                    console.log(response);
                });
        },
        addUser({commit}, {datas}) {
            return API.addUser(datas);
        },
    },
    getters: {
        InterfaceSettings: state => state.interfaceSettings,
    }
})
