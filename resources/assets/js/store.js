import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

export const store = new Vuex.Store({
  state: {
    user: {},
    currentArea: {},
    currentMarket: {}
  },

  getters: {

  },

  mutations: {
    user(state, p) {
      state.user = p
    },
    currentArea(state, p) {
      state.currentArea = p
    },
    currentMarket(state, p) {
      state.currentMarket = p
    }
  }
})
