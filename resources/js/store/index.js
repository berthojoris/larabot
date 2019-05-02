import Vuex from 'vuex';
import Vue from 'vue';
import createPersistedState from 'vuex-persistedstate';
import personalchat from  './modules/personalchat';

Vue.use(Vuex);

export default new Vuex.Store({
    // plugins: [createPersistedState()],
    namespaced: true,
    modules: {
        personalchat
    }
});