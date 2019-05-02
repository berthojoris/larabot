import axios from 'axios';

const state = {
    chatSender: [],
    chatReceiver: [],
    errorBag: null,
    chatOpenStatus: false,
    chatHistory: []
};

const getters = {
    getSender: state => state.chatSender,
    getReceiver: state => state.chatReceiver
};

const actions = {
    async openChatWith({ commit }, id) {
        try {
            let response    = await axios.post('/user', {id: id})
            let dataDB      = await response.data;
            commit('OPEN_CHAT_WITH', dataDB)
        } catch(error) {
            state.errorBag = error
        }
    }
};

const mutations = {
    OPEN_CHAT_WITH: (state, data) => {
        state.chatReceiver = data
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};