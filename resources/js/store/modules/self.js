const state = {
    personalData: [],
    errorBag: null
};

const getters = {
    getPersonalData: state => state.personalData
};

const actions = {
    setPersonalData({ commit }, data) {
        commit('SET_PERSONAL_DATA', data)
    }
};

const mutations = {
    SET_PERSONAL_DATA: (state, data) => {
        state.personalData = data
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};