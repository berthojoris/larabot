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
    async userListApi({ commit, dispatch }) {
        try {
            const response    = await axios.get('/user/online')
            const dataDB      = await response.data;
            commit('SET_USER_LIST', dataDB)
            dispatch('userMessageCount');
        } catch(error) {
            state.errorBag = error
        }
    },
    async userMessageCount({ commit }) {
        try {
            const response    = await axios.get('/chat/get/unread')
            const dataDB      = await response.data;
            commit('SET_USER_MESSAGE_COUNT', dataDB)
        } catch(error) {
            state.errorBag = error
            console.log(error);
        }
    }
};

const mutations = {
    SET_USER_LIST: (state, data) => {
        state.userList = data
    },
    SET_USER_MESSAGE_COUNT: (state, data) => {
        if(!_.isEmpty(state.userList)) {
            _.forEach(data, function(value, key) {
                __.findWhere(state.userList, {id: value.sender_id}).unread = value.msg_count
            });
            state.userMessageCount = data
        }
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};