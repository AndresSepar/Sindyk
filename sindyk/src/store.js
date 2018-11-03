import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    structure: {
      menu: [],
      information: {
        image: null,
        title: null,
        description: null,
        logo_light: null,
        logo_dark: null,
        plans: []
      }
    }
  },
  mutations: {
    ADD_STRUCTURE (state, payload) {
      state.structure = payload
    }
  },
  actions: {
    addStructure ({ commit }, payload) {
      commit('ADD_STRUCTURE', payload)
    }
  },
  getters: {
    structure (state) {
      return state.structure
    }
  }
})
