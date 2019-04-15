import Vue from 'vue'
import Vuex from 'vuex'
import API from '../src/API.js'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        interfaceSettings: {},
        sessionId: 0,
        userInfos: {},
        userResult: {},
    },
    mutations: {
        setInterface(state, params) {
            state.interfaceSettings = params;
        },
        setSessionId(state, param) {
            state.sessionId = param;
        },
        setUserInfos(state, params) {
            state.userInfos = params;
        },
        setUserResult(state, params){
            state.userResult = params;
        },
    },
    actions: {
        getActualQuestion(commit, id) {
            return API.getActualQuestion(id);
        },
        addUser({commit}, {datas}) {
            return API.addUser(datas);
        },
        getAllNotStartedSessions() {
            return API.getAllNotStartedSessions();
        },
        subscribeUser(commit, datas) {
            return API.subscribeUser(datas)
        },
        userAnswer(commit, datas) {
            return API.userAnswer(datas);
        },
        getScore(commit, datas) {
            return API.getScore(datas);
        }
    },
    getters: {
        InterfaceSettings: state => state.interfaceSettings,
        SessionId: state => state.sessionId,
        UserInfos: state => state.userInfos,
        UserResult: state => state.userResult,
    }
})
