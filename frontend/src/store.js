import Vue from 'vue'
import Vuex from 'vuex'
import API from '../src/API.js'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {

  },
  mutations: {

  },
  actions: {
    getActualQuestion(){
      API.getActualQuestion()
          .done((response) => {
            console.log(response);
          });
    },
  }
})
