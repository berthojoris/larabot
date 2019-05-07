import Vuex from 'vuex';
import Vue from 'vue';
import createPersistedState from 'vuex-persistedstate';
import personalchat from  './modules/personalchat';
import self from  './modules/self';
import userlist from  './modules/userlist';
import unread from  './modules/unread';

Vue.use(Vuex);

export default new Vuex.Store({
    // plugins: [createPersistedState()],
    namespaced: true,
    modules: {
        personalchat,
        self,
        userlist,
        unread
    }
});