import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

export const store = new Vuex.Store({
  state: {
    user: {},
    currentArea: {},
    currentMarket: {},
    currentProduct: {},
    currentStokist: {},
    currentStore: {}
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
    },
    currentStokist(state, p) {
      state.currentStokist = p
    },
    currentStore(state, p) {
      state.currentStore = p
    }
  }
})
