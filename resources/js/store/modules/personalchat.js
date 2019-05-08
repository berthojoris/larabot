import axios from 'axios';

const state = {
    chatReceiver: [],
    errorBag: null,
    chatOpenStatus: false,
    chatHistory: [],
    loadingMessageStatus: false,
    emptyMessageStatus: false,
    typingMessageStatus: false,
    randomString: '',
    message: '',
};

const getters = {
    getReceiver: state => state.chatReceiver,
    getOpenChatStatus: state => state.chatOpenStatus,
    getChatHistory: state => state.chatHistory,
    getLoadingMessage: state => state.loadingMessageStatus,
    getEmptyMessage: state => state.emptyMessageStatus,
    getTypingMessage: state => state.typingMessageStatus,
    getRandomString: state => state.randomString,
    getMessage: state => state.message,
};

const actions = {
    newChatReceive({ commit, rootState, dispatch }, payload) {
        if(_.isEmpty(state.chatReceiver)) {
            const userListData  = rootState.userlist.userList
            commit('NEW_CHAT_MESSAGE_BUBLE', {
                userList: userListData,
                payload: payload
            })
        } else {
            commit('NEW_CHAT_ARRIVED', payload)
            dispatch('setToRead', payload.sender_id)
        }
    },
    async openChatWith({ commit }, id) {
        try {
            const response    = await axios.post('/user', {id: id})
            const dataDB      = await response.data
            commit('OPEN_CHAT_WITH', dataDB)
        } catch(error) {
            state.errorBag = error
        }
    },
    async openChatHistory({ commit, dispatch }, id) {
        commit('DEFAULT')
        try {
            const response    = await axios.post('/chat/history', {receiverID: id})
            const dataDB      = await response.data
            if(_.isEmpty(dataDB)) {
                commit('SET_EMPTY_MESSAGE_TRUE')
            } else {
                commit('SET_EMPTY_MESSAGE_FALSE')
            }
            commit('OPEN_CHATHISTORY', dataDB)
            commit('SET_LOADING_MESSAGE_FALSE')
            commit('SET_PANEL_MESSAGE_TRUE')
            dispatch('setToRead', id)
        } catch(error) {
            state.errorBag = error
        }
    },
    async send({ commit, rootState }) {
        const currentUser   = rootState.self.personalData
        const sendUser      = state.chatReceiver
        commit('SET_EMPTY_MESSAGE_FALSE')
        commit('DONE_SEND', {
            from: currentUser,
            to: sendUser
        })
        try {
            const response    = await axios.post('/chat/insert', {
                receive_id: state.chatReceiver.id,
                message: state.message
            })
            const dataDB      = await response.data
        } catch(error) {
            state.errorBag = error
        }
    },
    async setToRead({ commit, rootState }, id) {
        const userListData    = rootState.userlist.userList
        commit('SET_TO_READ', userListData)
        try {
            const response    = await axios.get('/chat/set/read/'+id)
            const dataDB      = await response.data
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
        commit('SET_PANEL_MESSAGE_TRUE')
    },
    setTypingMessageFalse({ commit }) {
        commit('SET_TYPING_MESSAGE_FALSE')
    },
    setClearHistoryChat({ commit }) {
        commit('OPEN_CHATHISTORY')
    },
    setRandomStr({ commit }) {
        commit('RANDOM_STR')
    },
};

const mutations = {
    NEW_CHAT_MESSAGE_BUBLE: (state, payload) => {
        const ul    = payload.userList
        const pay   = payload.payload
        _.find(ul, {'id': pay.sender_id}).last_message   = pay.message
        _.find(ul, {'id': pay.sender_id}).unread         = _.find(ul, {'id': pay.sender_id}).unread+1
    },
    NEW_CHAT_ARRIVED: (state, payload) => {
        state.chatHistory.push(payload)
    },
    SET_TO_READ: (state, payload) => {
        const userOpenWith = state.chatReceiver
        if(!_.isEmpty(userOpenWith)) {
            _.find(payload, {id: userOpenWith.id}).unread = 0
        }
    },
    DONE_SEND: (state, payload) => {
        state.chatHistory.push({
            sender_id: payload.from.id,
            sender_image: payload.from.image,
            receive_image: payload.to.image,
            type: 'replies',
            message: state.message
        })
    },
    message (state, value) {
        state.message = value;
    },
    OPEN_CHAT_WITH: (state, data) => {
        state.chatReceiver = data
    },
    SET_OPEN_CHAT_STATUS: (state) => {
        state.chatOpenStatus = true
    },
    OPEN_CHATHISTORY: (state, data) => {
        state.chatHistory = data
    },
    CLEAR_CHATHISTORY: (state) => {
        state.chatHistory = []
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
    SET_PANEL_MESSAGE_TRUE: (state) => {
        state.typingMessageStatus = true
    },
    SET_TYPING_MESSAGE_FALSE: (state) => {
        state.typingMessageStatus = false
    },
    RANDOM_STR: (state) => {
        var str = RandomWords({
            exactly: 10,
            join: ' '
        })
        state.randomString = str.charAt(0).toUpperCase() + str.slice(1)
    },
    DEFAULT: (state) => {
        state.chatHistory = []
        state.emptyMessageStatus = false
        state.loadingMessageStatus = true
        state.typingMessageStatus = false
        var str = RandomWords({
            exactly: 10,
            join: ' '
        })
        state.randomString = str.charAt(0).toUpperCase() + str.slice(1)
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};