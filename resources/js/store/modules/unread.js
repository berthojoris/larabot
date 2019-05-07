const state = {
    chantUnread: [],
    errorBag: null
};

const getters = {
    getUnreadChat: state => state.chantUnread
};

const actions = {
    setUnreadChat({ commit }, data) {
        commit('SET_UNREAD', data)
    },
    setReadChat({ commit }, data) {
        commit('SET_READ', data)
    }
};

const mutations = {
    SET_UNREAD: (state, data) => {
        state.chantUnread = data
    },
    SET_TO_READ: (state, data) => {
        state.chantUnread = data
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};