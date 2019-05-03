import axios from 'axios';

const state = {
    chatSender: [],
    chatReceiver: [],
    errorBag: null,
    chatOpenStatus: false,
    chatHistory: [],
    loadingMessageStatus: false,
    emptyMessageStatus: false,
    typingMessageStatus: false,
};

const getters = {
    getSender: state => state.chatSender,
    getReceiver: state => state.chatReceiver,
    getOpenChatStatus: state => state.chatOpenStatus,
    getChatHistory: state => state.chatHistory,
    getLoadingMessage: state => state.loadingMessageStatus,
    getEmptyMessage: state => state.emptyMessageStatus,
    getTypingMessage: state => state.typingMessageStatus,
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
    },
    async openChatHistory({ commit }, id) {
        commit('SET_LOADING_MESSAGE_TRUE')
        commit('SET_TYPING_MESSAGE_FALSE')
        try {
            let response    = await axios.post('/chat/history', {receiverID: id})
            let dataDB      = await response.data;
            commit('OPEN_CHATHISTORY', dataDB)
            commit('SET_LOADING_MESSAGE_FALSE')
            commit('SET_TYPING_MESSAGE_TRUE')
        } catch(error) {
            state.errorBag = error
        }
    },
    setOpenChatStatus({ commit }) {
        commit('SET_OPEN_CHAT_STATUS')
    },
    setLoadingMessageTrue({ commit }) {
        commit('SET_LOADING_MESSAGE_TRUE')
    },
    setLoadingMessageFalse({ commit }) {
        commit('SET_LOADING_MESSAGE_FALSE')
    },
    setLoadingMessageTrue({ commit }) {
        commit('SET_EMPTY_MESSAGE_TRUE')
    },
    setLoadingMessageFalse({ commit }) {
        commit('SET_EMPTY_MESSAGE_FALSE')
    },
    setTypingMessageTrue({ commit }) {
        commit('SET_TYPING_MESSAGE_TRUE')
    },
    setTypingMessageFalse({ commit }) {
        commit('SET_TYPING_MESSAGE_FALSE')
    },
};

const mutations = {
    OPEN_CHAT_WITH: (state, data) => {
        state.chatReceiver = data
    },
    SET_OPEN_CHAT_STATUS: (state) => {
        state.chatOpenStatus = true
    },
    OPEN_CHATHISTORY: (state, data) => {
        state.chatHistory = data
    },
    SET_LOADING_MESSAGE_TRUE: (state) => {
        state.loadingMessageStatus = true
    },
    SET_LOADING_MESSAGE_FALSE: (state) => {
        state.loadingMessageStatus = false
    },
    SET_EMPTY_MESSAGE_TRUE: (state) => {
        state.emptyMessageStatus = true
    },
    SET_EMPTY_MESSAGE_FALSE: (state) => {
        state.emptyMessageStatus = false
    },
    SET_TYPING_MESSAGE_TRUE: (state) => {
        state.typingMessageStatus = true
    },
    SET_TYPING_MESSAGE_FALSE: (state) => {
        state.typingMessageStatus = false
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};