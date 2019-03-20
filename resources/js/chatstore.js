import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex);

export default new Vuex.Store({
    plugins: [createPersistedState()],

    state: {
        dataChatFromDB: [],
        socketSenderID: null,
        socketReceiveID: null,
        socketMessage: null,
        socketType: null,
        openPersonalChatStatus: false,
        openPersonalChatSender: null,
        openPersonalChatReceive: null,
        messagetext: ''
    },

    mutations: {
        chatFromDB (state) {
            const id = window.App.user.id

            axios.get('/api/chat/list/'+id+'/'+receiverID)
                .then((response) => {
                    this.loadStatus = false
                    let chatDB = response.data
                    this.chats = chatDB

                    if (!_.isEmpty(this.chats)) {
                        this.whenChatReady()
                        this.$nextTick(() => {
                            VueScrollTo.scrollTo("div.messages ul li:last-child", 0, {
                                container: '.messages'
                            })
                        })
                    } else {
                        this.whenNoChat()
                    }
                })
                .catch((error) => {
                    
                })
                .then(function () {

                });
        },
        sendChat (state) {

        },
        getChat (state) {
            
        },
        openChatPanel (state) {

        }
    },

    actions: {},
});
