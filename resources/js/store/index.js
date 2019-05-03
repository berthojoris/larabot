import Vuex from 'vuex';
import Vue from 'vue';
import createPersistedState from 'vuex-persistedstate';
import personalchat from  './modules/personalchat';
import self from  './modules/self';

Vue.use(Vuex);

export default new Vuex.Store({
    // plugins: [createPersistedState()],
    namespaced: true,
    modules: {
        personalchat,
        self
    }
});