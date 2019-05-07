const state = {
    userList: [],
    userMessageCount: [],
    errorBag: null
};

const getters = {
    getUserList: state => state.userList,
    getUserMessageCount: state => state.userMessageCount
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
    async userMessageCount({ commit }) {
        try {
            let response    = await axios.get('/chat/get/unread')
            let dataDB      = await response.data;
            commit('SET_USER_MESSAGE_COUNT', dataDB)
        } catch(error) {
            state.errorBag = error
        }
    }
};

const mutations = {
    SET_USER_LIST: (state, data) => {
        state.userList = data
    },
    SET_USER_MESSAGE_COUNT: (state, data) => {
        state.userMessageCount = data
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};