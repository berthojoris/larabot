const state = {
    userList: [],
    errorBag: null
};

const getters = {
    getUserList: state => state.userList
};

const actions = {
    async userListApi({ commit }) {
        try {
            let response    = await axios.get('/user/online')
            let dataDB      = await response.data;
            commit('SET_USER_LIST', dataDB)
        } catch(error) {
            state.errorBag = error
        }
    },
};

const mutations = {
    SET_USER_LIST: (state, data) => {
        state.userList = data
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};